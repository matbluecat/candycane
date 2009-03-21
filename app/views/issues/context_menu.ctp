<ul>
<% if !@issue.nil? -%>
	<li><%= context_menu_link l(:button_edit), {:controller => 'issues', :action => 'edit', :id => @issue},
	        :class => 'icon-edit', :disabled => !@can[:edit] %></li>
	<li class="folder">			
		<a href="#" class="submenu" onclick="return false;"><%= l(:field_status) %></a>
		<ul>
		<% @statuses.each do |s| -%>
		    <li><%= context_menu_link s.name, {:controller => 'issues', :action => 'edit', :id => @issue, :issue => {:status_id => s}, :back_to => @back}, :method => :post,
		                              :selected => (s == @issue.status), :disabled => !(@can[:update] && @allowed_statuses.include?(s)) %></li>
		<% end -%>
		</ul>
	</li>
<% else %>
	<li><%= context_menu_link l(:button_edit), {:controller => 'issues', :action => 'bulk_edit', :ids => @issues.collect(&:id)},
	        :class => 'icon-edit', :disabled => !@can[:edit] %></li>
<% end %>

	<li class="folder">			
		<a href="#" class="submenu"><%= l(:field_priority) %></a>
		<ul>
		<% @priorities.each do |p| -%>
		    <li><%= context_menu_link p.name, {:controller => 'issues', :action => 'bulk_edit', :ids => @issues.collect(&:id), 'priority_id' => p, :back_to => @back}, :method => :post,
		                              :selected => (@issue && p == @issue.priority), :disabled => !@can[:edit] %></li>
		<% end -%>
		</ul>
	</li>
	<% unless @project.nil? || @project.versions.empty? -%>
	<li class="folder">			
		<a href="#" class="submenu"><%= l(:field_fixed_version) %></a>
		<ul>
		<% @project.versions.sort.each do |v| -%>
		    <li><%= context_menu_link v.name, {:controller => 'issues', :action => 'bulk_edit', :ids => @issues.collect(&:id), 'fixed_version_id' => v, :back_to => @back}, :method => :post,
		                              :selected => (@issue && v == @issue.fixed_version), :disabled => !@can[:update] %></li>
		<% end -%>
		    <li><%= context_menu_link l(:label_none), {:controller => 'issues', :action => 'bulk_edit', :ids => @issues.collect(&:id), 'fixed_version_id' => 'none', :back_to => @back}, :method => :post,
		                              :selected => (@issue && @issue.fixed_version.nil?), :disabled => !@can[:update] %></li>
		</ul>
	</li>
	<% end %>
	<% unless @assignables.nil? || @assignables.empty? -%>
	<li class="folder">			
		<a href="#" class="submenu"><%= l(:field_assigned_to) %></a>
		<ul>
		<% @assignables.each do |u| -%>
		    <li><%= context_menu_link u.name, {:controller => 'issues', :action => 'bulk_edit', :ids => @issues.collect(&:id), 'assigned_to_id' => u, :back_to => @back}, :method => :post,
		                              :selected => (@issue && u == @issue.assigned_to), :disabled => !@can[:update] %></li>
		<% end -%>
		    <li><%= context_menu_link l(:label_nobody), {:controller => 'issues', :action => 'bulk_edit', :ids => @issues.collect(&:id), 'assigned_to_id' => 'none', :back_to => @back}, :method => :post,
		                              :selected => (@issue && @issue.assigned_to.nil?), :disabled => !@can[:update] %></li>
		</ul>
	</li>
	<% end %>
	<% unless @project.nil? || @project.issue_categories.empty? -%>
	<li class="folder">			
		<a href="#" class="submenu"><%= l(:field_category) %></a>
		<ul>
		<% @project.issue_categories.each do |u| -%>
		    <li><%= context_menu_link u.name, {:controller => 'issues', :action => 'bulk_edit', :ids => @issues.collect(&:id), 'category_id' => u, :back_to => @back}, :method => :post,
		                              :selected => (@issue && u == @issue.category), :disabled => !@can[:update] %></li>
		<% end -%>
		    <li><%= context_menu_link l(:label_none), {:controller => 'issues', :action => 'bulk_edit', :ids => @issues.collect(&:id), 'category_id' => 'none', :back_to => @back}, :method => :post,
		                              :selected => (@issue && @issue.category.nil?), :disabled => !@can[:update] %></li>
		</ul>
	</li>
	<% end -%>
	<li class="folder">
		<a href="#" class="submenu"><%= l(:field_done_ratio) %></a>
		<ul>
		<% (0..10).map{|x|x*10}.each do |p| -%>
		    <li><%= context_menu_link "#{p}%", {:controller => 'issues', :action => 'bulk_edit', :ids => @issues.collect(&:id), 'done_ratio' => p, :back_to => @back}, :method => :post,
		                                  :selected => (@issue && p == @issue.done_ratio), :disabled => !@can[:edit] %></li>
		<% end -%>
		</ul>
	</li>
	
<% if !@issue.nil? %>
	<li><%= context_menu_link l(:button_copy), {:controller => 'issues', :action => 'new', :project_id => @project, :copy_from => @issue},
	        :class => 'icon-copy', :disabled => !@can[:copy] %></li>
	<% if @can[:log_time] -%>
	<li><%= context_menu_link l(:button_log_time), {:controller => 'timelog', :action => 'edit', :issue_id => @issue},
	        :class => 'icon-time' %></li>
	<% end %>
<% end %>

  <li><%= context_menu_link l(:button_move), {:controller => 'issues', :action => 'move', :ids => @issues.collect(&:id)},
	                        :class => 'icon-move', :disabled => !@can[:move]  %></li>
  <li><%= context_menu_link l(:button_delete), {:controller => 'issues', :action => 'destroy', :ids => @issues.collect(&:id)},
                            :method => :post, :confirm => l(:text_issues_destroy_confirmation), :class => 'icon-del', :disabled => !@can[:delete] %></li>
</ul>
