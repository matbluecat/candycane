<div class="contextual">
<%= link_to_if_authorized l(:button_log_time), {:controller => 'timelog', :action => 'edit', :project_id => @project, :issue_id => @issue}, :class => 'icon icon-time' %>
</div>

<%= render_timelog_breadcrumb %>

<h2><%= l(:label_spent_time) %></h2>

<% form_remote_tag(:url => {}, :update => 'content') do %>
  <% @criterias.each do |criteria| %>
    <%= hidden_field_tag 'criterias[]', criteria, :id => nil %>
  <% end %>
  <%= hidden_field_tag 'project_id', params[:project_id] %>
  <%= render :partial => 'date_range' %>

  <p><%= l(:label_details) %>: <%= select_tag 'columns', options_for_select([[l(:label_year), 'year'],
                                                                            [l(:label_month), 'month'],
                                                                            [l(:label_week), 'week'],
                                                                            [l(:label_day_plural).titleize, 'day']], @columns),
                                                        :onchange => "this.form.onsubmit();" %>

  <%= l(:button_add) %>: <%= select_tag('criterias[]', options_for_select([[]] + (@available_criterias.keys - @criterias).collect{|k| [l(@available_criterias[k][:label]), k]}),
                                                          :onchange => "this.form.onsubmit();",
                                                          :style => 'width: 200px',
                                                          :id => nil,
                                                          :disabled => (@criterias.length >= 3)) %>
     <%= link_to_remote l(:button_clear), {:url => {:project_id => @project, :period_type => params[:period_type], :period => params[:period], :from => @from, :to => @to, :columns => @columns},
                                           :update => 'content'
                                          }, :class => 'icon icon-reload' %></p>
<% end %>

<% unless @criterias.empty? %>
<div class="total-hours">
<p><%= l(:label_total) %>: <%= html_hours(lwr(:label_f_hour, @total_hours)) %></p>
</div>

<% unless @hours.empty? %>
<table class="list" id="time-report">
<thead>
<tr>
<% @criterias.each do |criteria| %>
  <th><%= l(@available_criterias[criteria][:label]) %></th>
<% end %>
<% columns_width = (40 / (@periods.length+1)).to_i %>
<% @periods.each do |period| %>
  <th class="period" width="<%= columns_width %>%"><%= period %></th>
<% end %>
  <th class="total" width="<%= columns_width %>%"><%= l(:label_total) %></th>
</tr>
</thead>
<tbody>
<%= render :partial => 'report_criteria', :locals => {:criterias => @criterias, :hours => @hours, :level => 0} %>
  <tr class="total">
  <td><%= l(:label_total) %></td>
  <%= '<td></td>' * (@criterias.size - 1) %>
  <% total = 0 -%>
  <% @periods.each do |period| -%>
    <% sum = sum_hours(select_hours(@hours, @columns, period.to_s)); total += sum -%>
    <td class="hours"><%= html_hours("%.2f" % sum) if sum > 0 %></td>
  <% end -%>
  <td class="hours"><%= html_hours("%.2f" % total) if total > 0 %></td>
  </tr>
</tbody>
</table>

<p class="other-formats">
<%= l(:label_export_to) %>
<span><%= link_to 'CSV', params.merge({:format => 'csv'}), :class => 'csv' %></span>
</p>
<% end %>
<% end %>

<% html_title l(:label_spent_time), l(:label_report) %>

