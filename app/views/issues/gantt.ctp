<% form_tag(params.merge(:month => nil, :year => nil, :months => nil), :id => 'query_form') do %>
<% if @query.new_record? %>
    <h2><%=l(:label_gantt)%></h2>
    <fieldset id="filters"><legend><%= l(:label_filter_plural) %></legend>
    <%= render :partial => 'queries/filters', :locals => {:query => @query} %>
    </fieldset>
<% else %>
    <h2><%=h @query.name %></h2>
    <% html_title @query.name %>
<% end %>

<fieldset id="date-range"><legend><%= l(:label_date_range) %></legend>
    <%= text_field_tag 'months', @gantt.months, :size => 2 %>
    <%= l(:label_months_from) %>
    <%= select_month(@gantt.month_from, :prefix => "month", :discard_type => true) %>
    <%= select_year(@gantt.year_from, :prefix => "year", :discard_type => true) %>
    <%= hidden_field_tag 'zoom', @gantt.zoom %>
</fieldset>

<p style="float:right; margin:0px;">
<%= if @gantt.zoom < 4
    link_to_remote image_tag('zoom_in.png'), {:url => @gantt.params.merge(:zoom => (@gantt.zoom+1)), :update => 'content'}, {:href => url_for(@gantt.params.merge(:zoom => (@gantt.zoom+1)))}
  else
    image_tag 'zoom_in_g.png'
  end %>
<%= if @gantt.zoom > 1
    link_to_remote image_tag('zoom_out.png'), {:url => @gantt.params.merge(:zoom => (@gantt.zoom-1)), :update => 'content'}, {:href => url_for(@gantt.params.merge(:zoom => (@gantt.zoom-1)))}
  else
    image_tag 'zoom_out_g.png'
  end %>
</p>

<p class="buttons">
<%= link_to_remote l(:button_apply), 
                   { :url => { :set_filter => (@query.new_record? ? 1 : nil) },
                     :update => "content",
                     :with => "Form.serialize('query_form')"
                   }, :class => 'icon icon-checked' %>
                   
<%= link_to_remote l(:button_clear),
                   { :url => { :set_filter => (@query.new_record? ? 1 : nil) }, 
                     :update => "content",
                   }, :class => 'icon icon-reload' if @query.new_record? %>
</p>
<% end %>

<%= error_messages_for 'query' %>
<% if @query.valid? %>
<% zoom = 1
@gantt.zoom.times { zoom = zoom * 2 }

subject_width = 330
header_heigth = 18

headers_height = header_heigth
show_weeks = false
show_days = false

if @gantt.zoom >1
    show_weeks = true
    headers_height = 2*header_heigth
    if @gantt.zoom > 2
        show_days = true
        headers_height = 3*header_heigth
    end
end

g_width = (@gantt.date_to - @gantt.date_from + 1)*zoom
g_height = [(20 * @gantt.events.length + 6)+150, 206].max
t_height = g_height + headers_height
%>

<table width="100%" style="border:0; border-collapse: collapse;">
<tr>
<td style="width:<%= subject_width %>px; padding:0px;">

<div style="position:relative;height:<%= t_height + 24 %>px;width:<%= subject_width + 1 %>px;">
<div style="right:-2px;width:<%= subject_width %>px;height:<%= headers_height %>px;background: #eee;" class="gantt_hdr"></div>
<div style="right:-2px;width:<%= subject_width %>px;height:<%= t_height %>px;border-left: 1px solid #c0c0c0;overflow:hidden;" class="gantt_hdr"></div>
<%
#
# Tasks subjects
#
top = headers_height + 8
@gantt.events.each do |i| %>
    <div style="position: absolute;line-height:1.2em;height:16px;top:<%= top %>px;left:4px;overflow:hidden;"><small>    
    <% if i.is_a? Issue %>
      	<%= h("#{i.project} -") unless @project && @project == i.project %>
      	<%= link_to_issue i %>:	<%=h i.subject %>
  	<% else %>
		<span class="icon icon-package">
	      	<%= h("#{i.project} -") unless @project && @project == i.project %>
	      	<%= link_to_version i %>
		</span>
  	<% end %>  	
  	</small></div>
    <% top = top + 20
end %>
</div>
</td>
<td>

<div style="position:relative;height:<%= t_height + 24 %>px;overflow:auto;">
<div style="width:<%= g_width-1 %>px;height:<%= headers_height %>px;background: #eee;" class="gantt_hdr">&nbsp;</div>
<% 
#
# Months headers
#
month_f = @gantt.date_from
left = 0
height = (show_weeks ? header_heigth : header_heigth + g_height)
@gantt.months.times do 
	width = ((month_f >> 1) - month_f) * zoom - 1
	%>
	<div style="left:<%= left %>px;width:<%= width %>px;height:<%= height %>px;" class="gantt_hdr">
	<%= link_to "#{month_f.year}-#{month_f.month}", @gantt.params.merge(:year => month_f.year, :month => month_f.month), :title => "#{month_name(month_f.month)} #{month_f.year}"%>
	</div>
	<% 
	left = left + width + 1
	month_f = month_f >> 1
end %>

<% 
#
# Weeks headers
#
if show_weeks
	left = 0
	height = (show_days ? header_heigth-1 : header_heigth-1 + g_height)
	if @gantt.date_from.cwday == 1
	    # @date_from is monday
        week_f = @gantt.date_from
	else
	    # find next monday after @date_from
		week_f = @gantt.date_from + (7 - @gantt.date_from.cwday + 1)
		width = (7 - @gantt.date_from.cwday + 1) * zoom-1
		%>
		<div style="left:<%= left %>px;top:19px;width:<%= width %>px;height:<%= height %>px;" class="gantt_hdr">&nbsp;</div>
		<% 
		left = left + width+1
	end %>
	<%
	while week_f <= @gantt.date_to
		width = (week_f + 6 <= @gantt.date_to) ? 7 * zoom -1 : (@gantt.date_to - week_f + 1) * zoom-1
		%>
		<div style="left:<%= left %>px;top:19px;width:<%= width %>px;height:<%= height %>px;" class="gantt_hdr">
		<small><%= week_f.cweek if width >= 16 %></small>
		</div>
		<% 
		left = left + width+1
		week_f = week_f+7
	end
end %>

<% 
#
# Days headers
#
if show_days
	left = 0
	height = g_height + header_heigth - 1
	wday = @gantt.date_from.cwday
	(@gantt.date_to - @gantt.date_from + 1).to_i.times do 
	width =  zoom - 1
	%>
	<div style="left:<%= left %>px;top:37px;width:<%= width %>px;height:<%= height %>px;font-size:0.7em;<%= "background:#f1f1f1;" if wday > 5 %>" class="gantt_hdr">
	<%= day_name(wday).first %>
	</div>
	<% 
	left = left + width+1
	wday = wday + 1
	wday = 1 if wday > 7
	end
end %>

<%
#
# Tasks
#
top = headers_height + 10
@gantt.events.each do |i| 
  if i.is_a? Issue 
	i_start_date = (i.start_date >= @gantt.date_from ? i.start_date : @gantt.date_from )
	i_end_date = (i.due_before <= @gantt.date_to ? i.due_before : @gantt.date_to )
	
	i_done_date = i.start_date + ((i.due_before - i.start_date+1)*i.done_ratio/100).floor
	i_done_date = (i_done_date <= @gantt.date_from ? @gantt.date_from : i_done_date )
	i_done_date = (i_done_date >= @gantt.date_to ? @gantt.date_to : i_done_date )
	
	i_late_date = [i_end_date, Date.today].min if i_start_date < Date.today
	
	i_left = ((i_start_date - @gantt.date_from)*zoom).floor 	
	i_width = ((i_end_date - i_start_date + 1)*zoom).floor - 2                  # total width of the issue (- 2 for left and right borders)
	d_width = ((i_done_date - i_start_date)*zoom).floor - 2                     # done width
	l_width = i_late_date ? ((i_late_date - i_start_date+1)*zoom).floor - 2 : 0 # delay width
	%>
	<div style="top:<%= top %>px;left:<%= i_left %>px;width:<%= i_width %>px;" class="task task_todo">&nbsp;</div>
	<% if l_width > 0 %>
	    <div style="top:<%= top %>px;left:<%= i_left %>px;width:<%= l_width %>px;" class="task task_late">&nbsp;</div>
	<% end %>
	<% if d_width > 0 %>
	    <div style="top:<%= top %>px;left:<%= i_left %>px;width:<%= d_width %>px;" class="task task_done">&nbsp;</div>
	<% end %>
	<div style="top:<%= top %>px;left:<%= i_left + i_width + 5 %>px;background:#fff;" class="task">
	<%= i.status.name %>
	<%= (i.done_ratio).to_i %>%
	</div>
	<div class="tooltip" style="position: absolute;top:<%= top %>px;left:<%= i_left %>px;width:<%= i_width %>px;height:12px;">
	<span class="tip">
    <%= render_issue_tooltip i %>
	</span></div>
<% else 
    i_left = ((i.start_date - @gantt.date_from)*zoom).floor
    %>
    <div style="top:<%= top %>px;left:<%= i_left %>px;width:15px;" class="task milestone">&nbsp;</div>
	<div style="top:<%= top %>px;left:<%= i_left + 12 %>px;background:#fff;" class="task">
		<%= h("#{i.project} -") unless @project && @project == i.project %>
		<strong><%=h i %></strong>
	</div>
<% end %>
	<% top = top + 20
end %>

<%
#
# Today red line (excluded from cache)
#
if Date.today >= @gantt.date_from and Date.today <= @gantt.date_to %>
    <div style="position: absolute;height:<%= g_height %>px;top:<%= headers_height + 1 %>px;left:<%= ((Date.today-@gantt.date_from+1)*zoom).floor()-1 %>px;width:10px;border-left: 1px dashed red;">&nbsp;</div>
<% end %>

</div>
</td>
</tr>
</table>

<table width="100%">
<tr>
<td align="left"><%= link_to_remote ('&#171; ' + l(:label_previous)), {:url => @gantt.params_previous, :update => 'content', :complete => 'window.scrollTo(0,0)'}, {:href => url_for(@gantt.params_previous)} %></td>
<td align="right"><%= link_to_remote (l(:label_next) + ' &#187;'), {:url => @gantt.params_next, :update => 'content', :complete => 'window.scrollTo(0,0)'}, {:href => url_for(@gantt.params_next)} %></td>
</tr>
</table>

<p class="other-formats">
<%= l(:label_export_to) %>
<span><%= link_to 'PDF', @gantt.params.merge(:format => 'pdf'), :class => 'pdf' %></span>
<% if @gantt.respond_to?('to_image') %>
<span><%= link_to 'PNG', @gantt.params.merge(:format => 'png'), :class => 'image' %></span>
<% end %>
</p>
<% end # query.valid? %>

<% content_for :sidebar do %>
    <%= render :partial => 'issues/sidebar' %>
<% end %>

<% html_title(l(:label_gantt)) -%>
