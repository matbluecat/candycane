<h2><%=l(:label_issue_category)%>: <%=h @category.name %></h2>

<% form_tag({}) do %>
<div class="box">
<p><strong><%= l(:text_issue_category_destroy_question, @issue_count) %></strong></p>
<p><label><%= radio_button_tag 'todo', 'nullify', true %> <%= l(:text_issue_category_destroy_assignments) %></label><br />
<% if @categories.size > 0 %>
<label><%= radio_button_tag 'todo', 'reassign', false %> <%= l(:text_issue_category_reassign_to) %></label>:
<%= select_tag 'reassign_to_id', options_from_collection_for_select(@categories, 'id', 'name') %></p>
<% end %>
</div>

<%= submit_tag l(:button_apply) %>
<%= link_to l(:button_cancel), :controller => 'projects', :action => 'settings', :id => @project, :tab => 'categories' %>
<% end %>
