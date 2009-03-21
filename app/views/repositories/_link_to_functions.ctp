<p>
<% if @repository.supports_cat? %>
    <%= link_to_if action_name != 'entry', l(:button_view), {:action => 'entry', :id => @project, :path => to_path_param(@path), :rev => @rev } %> |
<% end %>
<% if @repository.supports_annotate? %>
    <%= link_to_if action_name != 'annotate', l(:button_annotate), {:action => 'annotate', :id => @project, :path => to_path_param(@path), :rev => @rev } %> |
<% end %>
<%= link_to(l(:button_download), {:action => 'entry', :id => @project, :path => to_path_param(@path), :rev => @rev, :format => 'raw' }) if @repository.supports_cat? %>
<%= "(#{number_to_human_size(@entry.size)})" if @entry.size %>
</p>
