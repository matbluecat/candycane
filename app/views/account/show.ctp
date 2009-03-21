<div class="contextual">
<%= link_to(l(:button_edit), {:controller => 'users', :action => 'edit', :id => @user}, :class => 'icon icon-edit') if User.current.admin? %>
</div>

<h2><%= avatar @user %> <%=h @user.name %></h2>

<div class="splitcontentleft">
<ul>
	<% unless @user.pref.hide_mail %>
		<li><%=l(:field_mail)%>: <%= mail_to(h(@user.mail), nil, :encode => 'javascript') %></li>
	<% end %>
	<% for custom_value in @custom_values %>
	<% if !custom_value.value.empty? %>
    <li><%= custom_value.custom_field.name%>: <%=h show_value(custom_value) %></li>
	<% end %>
	<% end %>
    <li><%=l(:label_registered_on)%>: <%= format_date(@user.created_on) %></li>
	<% unless @user.last_login_on.nil? %>
		<li><%=l(:field_last_login_on)%>: <%= format_date(@user.last_login_on) %></li>
	<% end %>
</ul>

<% unless @memberships.empty? %>
<h3><%=l(:label_project_plural)%></h3>
<ul>
<% for membership in @memberships %>
	<li><%= link_to(h(membership.project.name), :controller => 'projects', :action => 'show', :id => membership.project) %>
    (<%=h membership.role.name %>, <%= format_date(membership.created_on) %>)</li>
<% end %>
</ul>
<% end %>
</div>

<div class="splitcontentright">

<% unless @events_by_day.empty? %>
<h3><%= link_to l(:label_activity), :controller => 'projects', :action => 'activity', :user_id => @user, :from => @events_by_day.keys.first %></h3>

<p>
<%=l(:label_reported_issues)%>: <%= Issue.count(:conditions => ["author_id=?", @user.id]) %>
</p>

<div id="activity">
<% @events_by_day.keys.sort.reverse.each do |day| %>
<h4><%= format_activity_day(day) %></h4>
<dl>
<% @events_by_day[day].sort {|x,y| y.event_datetime <=> x.event_datetime }.each do |e| -%>
  <dt class="<%= e.event_type %>">
  <span class="time"><%= format_time(e.event_datetime, false) %></span>
  <%= content_tag('span', h(e.project), :class => 'project') %>
  <%= link_to format_activity_title(e.event_title), e.event_url %></dt>
  <dd><span class="description"><%= format_activity_description(e.event_description) %></span></dd>
<% end -%>
</dl>
<% end -%>
</div>

<p class="other-formats">
    <%= l(:label_export_to) %>
    <%= link_to 'Atom', {:controller => 'projects', :action => 'activity', :user_id => @user, :format => :atom, :key => User.current.rss_key}, :class => 'feed' %>
</p>

<% content_for :header_tags do %>
		<%= auto_discovery_link_tag(:atom, :controller => 'projects', :action => 'activity', :user_id => @user, :format => :atom, :key => User.current.rss_key) %>
<% end %>
<% end %>
</div>

<% html_title @user.name %>
