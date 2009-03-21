<div class="contextual">
<% form_tag do %>
<%= l(:label_revision) %>: <%= text_field_tag 'rev', @rev, :size => 5 %>
<% end %>
</div>

<h2><%= render :partial => 'navigation', :locals => { :path => @path, :kind => 'dir', :revision => @rev } %></h2>

<%= render :partial => 'dir_list' %>
<%= render_properties(@properties) %>

<% content_for :header_tags do %>
<%= stylesheet_link_tag "scm" %>
<% end %>
