<div class="contextual">
  &#171;
  <% unless @changeset.previous.nil? -%>
    <%= link_to l(:label_previous), :controller => 'repositories', :action => 'revision', :id => @project, :rev => @changeset.previous.revision %>
  <% else -%>
    <%= l(:label_previous) %>
  <% end -%>
|
  <% unless @changeset.next.nil? -%>
    <%= link_to l(:label_next), :controller => 'repositories', :action => 'revision', :id => @project, :rev => @changeset.next.revision %>
  <% else -%>
    <%= l(:label_next) %>
  <% end -%>
  &#187;&nbsp;
  
  <% form_tag({:controller => 'repositories', :action => 'revision', :id => @project, :rev => nil}, :method => :get) do %>
    <%= text_field_tag 'rev', @rev, :size => 5 %>
    <%= submit_tag 'OK', :name => nil %>
  <% end %>
</div>

<h2><%= l(:label_revision) %> <%= format_revision(@changeset.revision) %></h2>

<p><% if @changeset.scmid %>ID: <%= @changeset.scmid %><br /><% end %>
<span class="author"><%= authoring(@changeset.committed_on, @changeset.author) %></span></p>

<%= textilizable @changeset.comments %>

<% if @changeset.issues.any? %>
<h3><%= l(:label_related_issues) %></h3>
<ul>
<% @changeset.issues.each do |issue| %>
  <li><%= link_to_issue issue %>: <%=h issue.subject %></li>
<% end %>
</ul>
<% end %>

<h3><%= l(:label_attachment_plural) %></h3>
<ul id="changes-legend">
<li class="change change-A"><%= l(:label_added) %></li>
<li class="change change-M"><%= l(:label_modified) %></li>
<li class="change change-C"><%= l(:label_copied) %></li>
<li class="change change-R"><%= l(:label_renamed) %></li>
<li class="change change-D"><%= l(:label_deleted) %></li>
</ul>

<p><%= link_to(l(:label_view_diff), :action => 'diff', :id => @project, :path => "", :rev => @changeset.revision) if @changeset.changes.any? %></p>

<div class="changeset-changes">
<%= render_changeset_changes %>
</div>

<% content_for :header_tags do %>
<%= stylesheet_link_tag "scm" %>
<% end %>

<% html_title("#{l(:label_revision)} #{@changeset.revision}") -%>
