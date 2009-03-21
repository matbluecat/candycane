<%= error_messages_for 'project' %>

<div class="box">
<!--[form:project]-->
<p><%= f.text_field :name, :required => true %><br /><em><%= l(:text_caracters_maximum, 30) %></em></p>

<% if User.current.admin? and !@root_projects.empty? %>
    <p><%= f.select :parent_id, (@root_projects.collect {|p| [p.name, p.id]}), { :include_blank => true } %></p>
<% end %>

<p><%= f.text_area :description, :rows => 5, :class => 'wiki-edit' %></p>
<p><%= f.text_field :identifier, :required => true, :disabled => @project.identifier_frozen? %>
<% unless @project.identifier_frozen? %>
<br /><em><%= l(:text_length_between, 2, 20) %> <%= l(:text_project_identifier_info) %></em>
<% end %></p>
<p><%= f.text_field :homepage, :size => 60 %></p>
<p><%= f.check_box :is_public %></p>
<%= wikitoolbar_for 'project_description' %>

<% @project.custom_field_values.each do |value| %>
	<p><%= custom_field_tag_with_label :project, value %></p>
<% end %>
<%= call_hook(:view_projects_form, :project => @project, :form => f) %>
</div>

<% unless @trackers.empty? %>
<fieldset class="box"><legend><%=l(:label_tracker_plural)%></legend>
<% @trackers.each do |tracker| %>
    <label class="floating">
    <%= check_box_tag 'project[tracker_ids][]', tracker.id, @project.trackers.include?(tracker) %>
    <%= tracker %>
    </label>
<% end %>
<%= hidden_field_tag 'project[tracker_ids][]', '' %>
</fieldset>
<% end %>

<% unless @issue_custom_fields.empty? %>
<fieldset class="box"><legend><%=l(:label_custom_field_plural)%></legend>
<% @issue_custom_fields.each do |custom_field| %>
    <label class="floating">
	<%= check_box_tag 'project[issue_custom_field_ids][]', custom_field.id, (@project.all_issue_custom_fields.include? custom_field), (custom_field.is_for_all? ? {:disabled => "disabled"} : {}) %>
	<%= custom_field.name %>
	</label>
<% end %>
<%= hidden_field_tag 'project[issue_custom_field_ids][]', '' %>
</fieldset>
<% end %>
<!--[eoform:project]-->
