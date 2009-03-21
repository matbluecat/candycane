<h2><%=l(:label_roadmap)%></h2>

<% if @versions.empty? %>
<p class="nodata"><%= l(:label_no_data) %></p>
<% else %>
<div id="roadmap">
<% @versions.each do |version| %>   
    <%= tag 'a', :name => version.name %>
    <h3 class="icon22 icon22-package"><%= link_to h(version.name), :controller => 'versions', :action => 'show', :id => version %></h3>
    <%= render :partial => 'versions/overview', :locals => {:version => version} %>
    <%= render(:partial => "wiki/content", :locals => {:content => version.wiki_page.content}) if version.wiki_page %>

    <% issues = version.fixed_issues.find(:all,
                                          :include => [:status, :tracker],
                                          :conditions => ["tracker_id in (#{@selected_tracker_ids.join(',')})"],
                                          :order => "#{Tracker.table_name}.position, #{Issue.table_name}.id") unless @selected_tracker_ids.empty?
       issues ||= []
    %>
    <% if issues.size > 0 %>
    <fieldset class="related-issues"><legend><%= l(:label_related_issues) %></legend>
    <ul>
    <%- issues.each do |issue| -%>
        <li><%= link_to_issue(issue) %>: <%=h issue.subject %></li>
    <%- end -%>
    </ul>
    </fieldset>
    <% end %>
<% end %>
</div>
<% end %>

<% content_for :sidebar do %>
<% form_tag({}, :method => :get) do %>
<h3><%= l(:label_roadmap) %></h3>
<% @trackers.each do |tracker| %>
  <label><%= check_box_tag "tracker_ids[]", tracker.id, (@selected_tracker_ids.include? tracker.id.to_s), :id => nil %>
  <%= tracker.name %></label><br />
<% end %>
<br />
<label for="completed"><%= check_box_tag "completed", 1, params[:completed] %> <%= l(:label_show_completed_versions) %></label>
<p><%= submit_tag l(:button_apply), :class => 'button-small', :name => nil %></p>
<% end %>

<h3><%= l(:label_version_plural) %></h3>
<% @versions.each do |version| %>
<%= link_to version.name, "##{version.name}" %><br />
<% end %>
<% end %>

<% html_title(l(:label_roadmap)) %>
