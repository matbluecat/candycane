<%= error_messages_for 'query' %>
<%= hidden_field_tag 'confirm', 1 %>

<div class="box">
<div class="tabular">
<p><label for="query_name"><%=l(:field_name)%></label>
<%= text_field 'query', 'name', :size => 80 %></p>

<% if User.current.admin? || (@project && current_role.allowed_to?(:manage_public_queries)) %>
<p><label for="query_is_public"><%=l(:field_is_public)%></label>
<%= check_box 'query', 'is_public',
      :onchange => (User.current.admin? ? nil : 'if (this.checked) {$("query_is_for_all").checked = false; $("query_is_for_all").disabled = true;} else {$("query_is_for_all").disabled = false;}') %></p>
<% end %>

<p><label for="query_is_for_all"><%=l(:field_is_for_all)%></label>
<%= check_box_tag 'query_is_for_all', 1, @query.project.nil?,
      :disabled => (!@query.new_record? && (@query.project.nil? || (@query.is_public? && !User.current.admin?))) %></p>

<p><label for="query_default_columns"><%=l(:label_default_columns)%></label>
<%= check_box_tag 'default_columns', 1, @query.has_default_columns?, :id => 'query_default_columns',
      :onclick => 'if (this.checked) {Element.hide("columns")} else {Element.show("columns")}' %></p>
</div>

<fieldset><legend><%= l(:label_filter_plural) %></legend>
<%= render :partial => 'queries/filters', :locals => {:query => query}%>
</fieldset>

<%= render :partial => 'queries/columns', :locals => {:query => query}%>
</div>
