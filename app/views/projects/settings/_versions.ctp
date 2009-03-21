<% if @project.versions.any? %>
<table class="list">
	<thead>
    <th><%= l(:label_version) %></th>
    <th><%= l(:field_effective_date) %></th>
    <th><%= l(:field_description) %></th>
    <th><%= l(:label_wiki_page) unless @project.wiki.nil? %></th>
    <th style="width:15%"></th>
    <th style="width:15%"></th>
    </thead>
	<tbody>
<% for version in @project.versions.sort %>
    <tr class="<%= cycle 'odd', 'even' %>">
    <td><%= link_to h(version.name), :controller => 'versions', :action => 'show', :id => version %></td>
    <td align="center"><%= format_date(version.effective_date) %></td>
    <td><%=h version.description %></td>
    <td><%= link_to(version.wiki_page_title, :controller => 'wiki', :page => Wiki.titleize(version.wiki_page_title)) unless version.wiki_page_title.blank? || @project.wiki.nil? %></td>
    <td align="center"><%= link_to_if_authorized l(:button_edit), { :controller => 'versions', :action => 'edit', :id => version }, :class => 'icon icon-edit' %></td>
    <td align="center"><%= link_to_if_authorized l(:button_delete), {:controller => 'versions', :action => 'destroy', :id => version}, :confirm => l(:text_are_you_sure), :method => :post, :class => 'icon icon-del' %></td>
    </tr>
<% end; reset_cycle %>
    </tbody>
</table>
<% else %>
<p class="nodata"><%= l(:label_no_data) %></p>
<% end %>

<p><%= link_to_if_authorized l(:label_version_new), :controller => 'projects', :action => 'add_version', :id => @project %></p>
