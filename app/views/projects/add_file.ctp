<h2><%=l(:label_attachment_new)%></h2>

<%= error_messages_for 'attachment' %>
<div class="box">
<% form_tag({ :action => 'add_file', :id => @project }, :multipart => true, :class => "tabular") do %>

<% if @versions.any? %>
<p><label for="version_id"><%=l(:field_version)%></label>
<%= select_tag "version_id", content_tag('option', '') +
														 options_from_collection_for_select(@versions, "id", "name") %></p>
<% end %>

<p><label><%=l(:label_attachment_plural)%></label><%= render :partial => 'attachments/form' %></p>
</div>
<%= submit_tag l(:button_add) %>
<% end %> 
