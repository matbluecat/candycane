<h2><%= @page.pretty_title %></h2>

<h3><%= l(:label_history) %></h3>

<% form_tag({:action => "diff"}, :method => :get) do %>
<table class="list">
<thead><tr>
    <th>#</th>
    <th></th>
    <th></th>    
    <th><%= l(:field_updated_on) %></th>
    <th><%= l(:field_author) %></th>
    <th><%= l(:field_comments) %></th>
    <th></th>
</tr></thead>
<tbody>
<% show_diff = @versions.size > 1 %>
<% line_num = 1 %>
<% @versions.each do |ver| %>
<tr class="<%= cycle("odd", "even") %>">
    <td class="id"><%= link_to ver.version, :action => 'index', :page => @page.title, :version => ver.version %></td>
    <td class="checkbox"><%= radio_button_tag('version', ver.version, (line_num==1), :id => "cb-#{line_num}", :onclick => "$('cbto-#{line_num+1}').checked=true;") if show_diff && (line_num < @versions.size) %></td>
    <td class="checkbox"><%= radio_button_tag('version_from', ver.version, (line_num==2), :id => "cbto-#{line_num}", :onclick => "if ($('cb-#{line_num}').checked==true || $('version_from').value > #{ver.version}) {$('cb-#{line_num-1}').checked=true;}") if show_diff && (line_num > 1) %></td>
    <td align="center"><%= format_time(ver.updated_on) %></td>
    <td><em><%= ver.author ? ver.author.name : "anonyme" %></em></td>
    <td><%=h ver.comments %></td>
    <td align="center"><%= link_to l(:button_annotate), :action => 'annotate', :page => @page.title, :version => ver.version %></td>
</tr>
<% line_num += 1 %>
<% end %>
</tbody>
</table>
<%= submit_tag l(:label_view_diff), :class => 'small' if show_diff %>
<span class="pagination"><%= pagination_links_full @version_pages, @version_count, :page_param => :p %></span>
<% end %>
