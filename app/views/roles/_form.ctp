<%= error_messages_for 'role' %> 

<% unless @role.builtin? %>
<div class="box">
<p><%= f.text_field :name, :required => true %></p>
<p><%= f.check_box :assignable %></p>
<% if @role.new_record? && @roles.any? %>
<p><label><%= l(:label_copy_workflow_from) %></label>
<%= select_tag(:copy_workflow_from, content_tag("option") + options_from_collection_for_select(@roles, :id, :name)) %></p>
<% end %>
</div>
<% end %>

<h3><%= l(:label_permissions) %></h3>
<div class="box" id="permissions">
<% perms_by_module = @permissions.group_by {|p| p.project_module.to_s} %>
<% perms_by_module.keys.sort.each do |mod| %>
    <fieldset><legend><%= mod.blank? ? l(:label_project) : l_or_humanize(mod, :prefix => 'project_module_') %></legend>
    <% perms_by_module[mod].each do |permission| %>
        <label class="floating">
        <%= check_box_tag 'role[permissions][]', permission.name, (@role.permissions.include? permission.name) %>
        <%= l_or_humanize(permission.name, :prefix => 'permission_') %>
        </label>
    <% end %>
    </fieldset>
<% end %>
<br /><%= check_all_links 'permissions' %>
<%= hidden_field_tag 'role[permissions][]', '' %>
</div>
