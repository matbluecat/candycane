<div class="contextual">
<%= link_to l(:label_issue_status_new), {:action => 'new'}, :class => 'icon icon-add' %>
</div>

<h2><%=l(:label_issue_status_plural)%></h2>
 
<table class="list">
  <thead><tr>
  <th><%=l(:field_status)%></th>
  <th><%=l(:field_is_default)%></th>
  <th><%=l(:field_is_closed)%></th>
  <th><%=l(:button_sort)%></th>
  <th></th>
  </tr></thead>
  <tbody>  
<% for status in @issue_statuses %>
  <tr class="<%= cycle("odd", "even") %>">
  <td><%= link_to status.name, :action => 'edit', :id => status %></td>
  <td align="center"><%= image_tag 'true.png' if status.is_default? %></td>
  <td align="center"><%= image_tag 'true.png' if status.is_closed? %></td>
  <td align="center" style="width:15%;">
    <%= link_to image_tag('2uparrow.png', :alt => l(:label_sort_highest)), {:action => 'move', :id => status, :position => 'highest'}, :method => :post, :title => l(:label_sort_highest) %>
    <%= link_to image_tag('1uparrow.png', :alt => l(:label_sort_higher)), {:action => 'move', :id => status, :position => 'higher'}, :method => :post, :title => l(:label_sort_higher) %> -
    <%= link_to image_tag('1downarrow.png', :alt => l(:label_sort_lower)), {:action => 'move', :id => status, :position => 'lower'}, :method => :post, :title => l(:label_sort_lower) %>
    <%= link_to image_tag('2downarrow.png', :alt => l(:label_sort_lowest)), {:action => 'move', :id => status, :position => 'lowest'}, :method => :post, :title => l(:label_sort_lowest) %>
  </td>
  <td align="center" style="width:10%;">
    <%= button_to l(:button_delete), { :action => 'destroy', :id => status }, :confirm => l(:text_are_you_sure), :class => "button-small" %>
  </td>
  </tr>
<% end %>
  </tbody>
</table>

<p class="pagination"><%= pagination_links_full @issue_status_pages %></p>

<% html_title(l(:label_issue_status_plural)) -%>
