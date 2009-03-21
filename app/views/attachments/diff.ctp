<h2><%=h @attachment.filename %></h2>

<div class="attachments">
<p><%= h("#{@attachment.description} - ") unless @attachment.description.blank? %>
   <span class="author"><%= @attachment.author %>, <%= format_time(@attachment.created_on) %></span></p>
<p><%= link_to_attachment @attachment, :text => l(:button_download), :download => true -%>
   <span class="size">(<%= number_to_human_size @attachment.filesize %>)</span></p>

</div>
&nbsp;
<%= render :partial => 'common/diff', :locals => {:diff => @diff, :diff_type => @diff_type} %>

<% content_for :header_tags do -%>
    <%= stylesheet_link_tag "scm" -%>
<% end -%>
