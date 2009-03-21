<div class="contextual">
<%= link_to_if_authorized(l(:button_update), {:controller => 'issues', :action => 'edit', :id => @issue }, :onclick => 'showAndScrollTo("update", "notes"); return false;', :class => 'icon icon-edit', :accesskey => accesskey(:edit)) %>
<%= link_to_if_authorized l(:button_log_time), {:controller => 'timelog', :action => 'edit', :issue_id => @issue}, :class => 'icon icon-time' %>
<%= watcher_tag(@issue, User.current) %>
<%= link_to_if_authorized l(:button_copy), {:controller => 'issues', :action => 'new', :project_id => @project, :copy_from => @issue }, :class => 'icon icon-copy' %>
<%= link_to_if_authorized l(:button_move), {:controller => 'issues', :action => 'move', :id => @issue }, :class => 'icon icon-move' %>
<%= link_to_if_authorized l(:button_delete), {:controller => 'issues', :action => 'destroy', :id => @issue}, :confirm => l(:text_are_you_sure), :method => :post, :class => 'icon icon-del' %>
</div>

<h2><%= @issue.tracker.name %> #<%= @issue.id %></h2>

<div class="<%= css_issue_classes(@issue) %>">
        <%= avatar(@issue.author, :size => "64") %>
        <h3><%=h @issue.subject %></h3>
        <p class="author">
        <%= authoring @issue.created_on, @issue.author %>.
        <%= l(:label_updated_time, distance_of_time_in_words(Time.now, @issue.updated_on)) + '.' if @issue.created_on != @issue.updated_on %>
        </p>

<table width="100%">
<tr>
    <td style="width:15%" class="status"><b><%=l(:field_status)%>:</b></td><td style="width:35%" class="status"><%= @issue.status.name %></td>
    <td style="width:15%" class="start-date"><b><%=l(:field_start_date)%>:</b></td><td style="width:35%"><%= format_date(@issue.start_date) %></td>
</tr>
<tr>
    <td class="priority"><b><%=l(:field_priority)%>:</b></td><td class="priority"><%= @issue.priority.name %></td>
    <td class="due-date"><b><%=l(:field_due_date)%>:</b></td><td class="due-date"><%= format_date(@issue.due_date) %></td>
</tr>
<tr>
    <td class="assigned-to"><b><%=l(:field_assigned_to)%>:</b></td><td><%= avatar(@issue.assigned_to, :size => "14") %><%= @issue.assigned_to ? link_to_user(@issue.assigned_to) : "-" %></td>
    <td class="progress"><b><%=l(:field_done_ratio)%>:</b></td><td class="progress"><%= progress_bar @issue.done_ratio, :width => '80px', :legend => "#{@issue.done_ratio}%" %></td>
</tr>
<tr>
    <td class="category"><b><%=l(:field_category)%>:</b></td><td><%=h @issue.category ? @issue.category.name : "-" %></td>
    <% if User.current.allowed_to?(:view_time_entries, @project) %>
    <td class="spent-time"><b><%=l(:label_spent_time)%>:</b></td>
    <td class="spent-hours"><%= @issue.spent_hours > 0 ? (link_to lwr(:label_f_hour, @issue.spent_hours), {:controller => 'timelog', :action => 'details', :project_id => @project, :issue_id => @issue}, :class => 'icon icon-time') : "-" %></td>
    <% end %>
</tr>
<tr>
    <td class="fixed-version"><b><%=l(:field_fixed_version)%>:</b></td><td><%= @issue.fixed_version ? link_to_version(@issue.fixed_version) : "-" %></td>
    <% if @issue.estimated_hours %>
    <td class="estimated-hours"><b><%=l(:field_estimated_hours)%>:</b></td><td><%= lwr(:label_f_hour, @issue.estimated_hours) %></td>
    <% end %>
</tr>
<tr>
<% n = 0 -%>
<% @issue.custom_values.each do |value| -%>
    <td valign="top"><b><%=h value.custom_field.name %>:</b></td><td valign="top"><%= simple_format(h(show_value(value))) %></td>
<% n = n + 1
   if (n > 1) 
        n = 0 %>
        </tr><tr>
 <%end
end %>
</tr>
<%= call_hook(:view_issues_show_details_bottom, :issue => @issue) %>
</table>
<hr />

<div class="contextual">
<%= link_to_remote_if_authorized(l(:button_quote), { :url => {:action => 'reply', :id => @issue} }, :class => 'icon icon-comment') unless @issue.description.blank? %>
</div>
                              
<p><strong><%=l(:field_description)%></strong></p>
<div class="wiki">
<%= textilizable @issue, :description, :attachments => @issue.attachments %>
</div>

<%= link_to_attachments @issue %>

<% if authorize_for('issue_relations', 'new') || @issue.relations.any? %>
<hr />
<div id="relations">
<%= render :partial => 'relations' %>
</div>
<% end %>

<% if User.current.allowed_to?(:add_issue_watchers, @project) ||
        (@issue.watchers.any? && User.current.allowed_to?(:view_issue_watchers, @project)) %>
<hr />
<div id="watchers">
<%= render :partial => 'watchers/watchers', :locals => {:watched => @issue} %>
</div>
<% end %>

</div>

<% if @issue.changesets.any? && User.current.allowed_to?(:view_changesets, @project) %>
<div id="issue-changesets">
<h3><%=l(:label_associated_revisions)%></h3>
<%= render :partial => 'changesets', :locals => { :changesets => @issue.changesets} %>
</div>
<% end %>

<% if @journals.any? %>
<div id="history">
<h3><%=l(:label_history)%></h3>
<%= render :partial => 'history', :locals => { :journals => @journals } %>
</div>
<% end %>
<div style="clear: both;"></div>

<% if authorize_for('issues', 'edit') %>
  <div id="update" style="display:none;">
  <h3><%= l(:button_update) %></h3>
  <%= render :partial => 'edit' %>
  </div>
<% end %>

<p class="other-formats">
<%= l(:label_export_to) %>
<span><%= link_to 'Atom', {:format => 'atom', :key => User.current.rss_key}, :class => 'feed' %></span>
<span><%= link_to 'PDF', {:format => 'pdf'}, :class => 'pdf' %></span>
</p>

<% html_title "#{@issue.tracker.name} ##{@issue.id}: #{@issue.subject}" %>

<% content_for :sidebar do %>
    <%= render :partial => 'issues/sidebar' %>
<% end %>

<% content_for :header_tags do %>
    <%= auto_discovery_link_tag(:atom, {:format => 'atom', :key => User.current.rss_key}, :title => "#{@issue.project} - #{@issue.tracker} ##{@issue.id}: #{@issue.subject}") %>
    <%= stylesheet_link_tag 'scm' %>
<% end %>
