<div class="contextual">
<% if @editable %>
<%= link_to_if_authorized(l(:button_edit), {:action => 'edit', :page => @page.title}, :class => 'icon icon-edit', :accesskey => accesskey(:edit)) if @content.version == @page.content.version %>
<%= link_to_if_authorized(l(:button_lock), {:action => 'protect', :page => @page.title, :protected => 1}, :method => :post, :class => 'icon icon-lock') if !@page.protected? %>
<%= link_to_if_authorized(l(:button_unlock), {:action => 'protect', :page => @page.title, :protected => 0}, :method => :post, :class => 'icon icon-unlock') if @page.protected? %>
<%= link_to_if_authorized(l(:button_rename), {:action => 'rename', :page => @page.title}, :class => 'icon icon-move') if @content.version == @page.content.version %>
<%= link_to_if_authorized(l(:button_delete), {:action => 'destroy', :page => @page.title}, :method => :post, :confirm => l(:text_are_you_sure), :class => 'icon icon-del') %>
<%= link_to_if_authorized(l(:button_rollback), {:action => 'edit', :page => @page.title, :version => @content.version }, :class => 'icon icon-cancel') if @content.version < @page.content.version %>
<% end %>
<%= link_to_if_authorized(l(:label_history), {:action => 'history', :page => @page.title}, :class => 'icon icon-history') %>
</div>

<%= breadcrumb(@page.ancestors.reverse.collect {|parent| link_to h(parent.pretty_title), {:page => parent.title}}) %>

<% if @content.version != @page.content.version %>
    <p>    
    <%= link_to(('&#171; ' + l(:label_previous)), :action => 'index', :page => @page.title, :version => (@content.version - 1)) + " - " if @content.version > 1 %>
    <%= "#{l(:label_version)} #{@content.version}/#{@page.content.version}" %>
    <%= '(' + link_to('diff', :controller => 'wiki', :action => 'diff', :page => @page.title, :version => @content.version) + ')' if @content.version > 1 %> - 
    <%= link_to((l(:label_next) + ' &#187;'), :action => 'index', :page => @page.title, :version => (@content.version + 1)) + " - " if @content.version < @page.content.version %>
    <%= link_to(l(:label_current_version), :action => 'index', :page => @page.title) %>
    <br />
    <em><%= @content.author ? @content.author.name : "anonyme" %>, <%= format_time(@content.updated_on) %> </em><br />
    <%=h @content.comments %>
    </p>
    <hr />
<% end %>

<%= render(:partial => "wiki/content", :locals => {:content => @content}) %>

<%= link_to_attachments @page %>

<% if @editable && authorize_for('wiki', 'add_attachment') %>
<p><%= link_to l(:label_attachment_new), {}, :onclick => "Element.show('add_attachment_form'); Element.hide(this); Element.scrollTo('add_attachment_form'); return false;",
                                             :id => 'attach_files_link' %></p>
<% form_tag({ :controller => 'wiki', :action => 'add_attachment', :page => @page.title }, :multipart => true, :id => "add_attachment_form", :style => "display:none;") do %>
  <div class="box">
  <p><%= render :partial => 'attachments/form' %></p>
  </div>
<%= submit_tag l(:button_add) %>
<%= link_to l(:button_cancel), {}, :onclick => "Element.hide('add_attachment_form'); Element.show('attach_files_link'); return false;" %>
<% end %>
<% end %>

<p class="other-formats">
<%= l(:label_export_to) %>
<span><%= link_to 'HTML', {:page => @page.title, :export => 'html', :version => @content.version}, :class => 'html' %></span>
<span><%= link_to 'TXT', {:page => @page.title, :export => 'txt', :version => @content.version}, :class => 'text' %></span>
</p>

<% content_for :header_tags do %>
  <%= stylesheet_link_tag 'scm' %>
<% end %>

<% content_for :sidebar do %>
  <%= render :partial => 'sidebar' %>
<% end %>

<% html_title @page.pretty_title %>
