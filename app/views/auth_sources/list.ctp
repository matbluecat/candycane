<div class="contextual">
<%= link_to l(:label_auth_source_new), {:action => 'new'}, :class => 'icon icon-add' %>
</div>

<h2><%=l(:label_auth_source_plural)%></h2>

<table class="list">
  <thead><tr>
	  <th><%=l(:field_name)%></th>
	  <th><%=l(:field_type)%></th>
	  <th><%=l(:field_host)%></th>
	  <th><%=l(:label_user_plural)%></th>
	  <th></th>
	  <th></th>
  </tr></thead>
  <tbody>
<% for source in @auth_sources %>
  <tr class="<%= cycle("odd", "even") %>">
    <td><%= link_to source.name, :action => 'edit', :id => source%></td>
    <td align="center"><%= source.auth_method_name %></td>
    <td align="center"><%= source.host %></td>    
    <td align="center"><%= source.users.count %></td>
    <td align="center"><%= link_to l(:button_test), :action => 'test_connection', :id => source %></td>
    <td align="center"><%= button_to l(:button_delete), { :action => 'destroy', :id => source },
                                                        :confirm => l(:text_are_you_sure),
                                                        :class => "button-small",
                                                        :disabled => source.users.any? %></td>
  </tr>
<% end %>
  </tbody>
</table>

<p class="pagination"><%= pagination_links_full @auth_source_pages %></p>
