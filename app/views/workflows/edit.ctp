<div class="contextual">
<%= link_to l(:field_summary), :action => 'index' %>
</div>

<h2><%=l(:label_workflow)%></h2>

<p><%=l(:text_workflow_edit)%>:</p>

<% form_tag({}, :method => 'get') do %>
<p><label for="role_id"><%=l(:label_role)%>:</label>
<select name="role_id">
  <%= options_from_collection_for_select @roles, "id", "name", (@role.id unless @role.nil?) %>
</select>

<label for="tracker_id"><%=l(:label_tracker)%>:</label>
<select name="tracker_id">
  <%= options_from_collection_for_select @trackers, "id", "name", (@tracker.id unless @tracker.nil?) %>
</select>
<%= submit_tag l(:button_edit), :name => nil %>
</p>
<% end %>
  
  

<% unless @tracker.nil? or @role.nil? or @statuses.empty? %>
<% form_tag({}, :id => 'workflow_form' ) do %>
<%= hidden_field_tag 'tracker_id', @tracker.id %>
<%= hidden_field_tag 'role_id', @role.id %>
<table class="list">
<thead>
	<tr>
	<th align="left"><%=l(:label_current_status)%></th>
	<th align="center" colspan="<%= @statuses.length %>"><%=l(:label_new_statuses_allowed)%></th>
	</tr>
	<tr>
	<td></td>
	<% for new_status in @statuses %>
		<td width="<%= 75 / @statuses.size %>%" align="center"><%= new_status.name %></td>
	<% end %>
	</tr>
</thead>
<tbody>
	<% for old_status in @statuses %>
		<tr class="<%= cycle("odd", "even") %>">
		<td><%= old_status.name %></td>
		<% new_status_ids_allowed = old_status.find_new_statuses_allowed_to(@role, @tracker).collect(&:id) -%>
		<% for new_status in @statuses -%>
			<td align="center">
      <input type="checkbox"
      name="issue_status[<%= old_status.id %>][]"
      value="<%= new_status.id %>"
      <%= 'checked="checked"' if new_status_ids_allowed.include? new_status.id %> />			
			</td>
		<% end -%>
		</tr>
	<% end %>
</tbody>
</table>
<p><%= check_all_links 'workflow_form' %></p>

<%= submit_tag l(:button_save) %>
<% end %>

<% end %>

<% html_title(l(:label_workflow)) -%>
