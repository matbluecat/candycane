<h2><%=l(:label_confirmation)%></h2>
<div class="warning">
<p><strong><%=h @project_to_destroy %></strong><br />
<%=l(:text_project_destroy_confirmation)%>

<% if @project_to_destroy.children.any? %>
<br /><%= l(:text_subprojects_destroy_warning, content_tag('strong', h(@project_to_destroy.children.sort.collect{|p| p.to_s}.join(', ')))) %>
<% end %>
</p>
<p>
    <% form_tag({:controller => 'projects', :action => 'destroy', :id => @project_to_destroy}) do %>
    <label><%= check_box_tag 'confirm', 1 %> <%= l(:general_text_Yes) %></label>
    <%= submit_tag l(:button_delete) %>
    <% end %>
</p>
</div>
