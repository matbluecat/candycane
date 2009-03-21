<%= link_to 'root', :action => 'browse', :id => @project, :path => '', :rev => @rev %>
<% 
dirs = path.split('/')
if 'file' == kind
    filename = dirs.pop
end
link_path = ''
dirs.each do |dir|
    next if dir.blank?
    link_path << '/' unless link_path.empty?
    link_path << "#{dir}" 
    %>
    / <%= link_to h(dir), :action => 'browse', :id => @project, :path => to_path_param(link_path), :rev => @rev %>
<% end %>
<% if filename %>
    / <%= link_to h(filename), :action => 'changes', :id => @project, :path => to_path_param("#{link_path}/#{filename}"), :rev => @rev %>
<% end %>

<%= "@ #{revision}" if revision %>

<% html_title(with_leading_slash(path)) -%>
