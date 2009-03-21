<%= breadcrumb link_to(l(:label_board_plural), {:controller => 'boards', :action => 'index', :project_id => @project}) %>

<div class="contextual">
<%= link_to_if_authorized l(:label_message_new),
                          {:controller => 'messages', :action => 'new', :board_id => @board},
                          :class => 'icon icon-add',
                          :onclick => 'Element.show("add-message"); return false;' %>
<%= watcher_tag(@board, User.current) %>
</div>

<div id="add-message" style="display:none;">
<h2><%= link_to h(@board.name), :controller => 'boards', :action => 'show', :project_id => @project, :id => @board %> &#187; <%= l(:label_message_new) %></h2>
<% form_for :message, @message, :url => {:controller => 'messages', :action => 'new', :board_id => @board}, :html => {:multipart => true, :id => 'message-form'} do |f| %>
  <%= render :partial => 'messages/form', :locals => {:f => f} %>
  <p><%= submit_tag l(:button_create) %>
  <%= link_to_remote l(:label_preview), 
                     { :url => { :controller => 'messages', :action => 'preview', :board_id => @board },
                       :method => 'post',
                       :update => 'preview',
                       :with => "Form.serialize('message-form')",
                       :complete => "Element.scrollTo('preview')"
                     }, :accesskey => accesskey(:preview) %> |
  <%= link_to l(:button_cancel), "#", :onclick => 'Element.hide("add-message")' %></p>
<% end %>
<div id="preview" class="wiki"></div>
</div>

<h2><%=h @board.name %></h2>
<p class="subtitle"><%=h @board.description %></p>

<% if @topics.any? %>
<table class="list messages">
  <thead><tr>
    <th><%= l(:field_subject) %></th>
    <th><%= l(:field_author) %></th>
    <%= sort_header_tag('created_on', :caption => l(:field_created_on)) %>
    <%= sort_header_tag('replies', :caption => l(:label_reply_plural)) %>
    <%= sort_header_tag('updated_on', :caption => l(:label_message_last)) %>
  </tr></thead>  
  <tbody>
  <% @topics.each do |topic| %>
    <tr class="message <%= cycle 'odd', 'even' %> <%= topic.sticky? ? 'sticky' : '' %> <%= topic.locked? ? 'locked' : '' %>">
      <td class="subject"><%= link_to h(topic.subject), { :controller => 'messages', :action => 'show', :board_id => @board, :id => topic }, :class => 'icon' %></td>
      <td class="author" align="center"><%= topic.author %></td>
      <td class="created_on" align="center"><%= format_time(topic.created_on) %></td>
      <td class="replies" align="center"><%= topic.replies_count %></td>
      <td class="last_message">
        <% if topic.last_reply %>
        <%= authoring topic.last_reply.created_on, topic.last_reply.author %><br />
        <%= link_to_message topic.last_reply %>
        <% end %>
      </td>
    </tr>
  <% end %>
  </tbody>
</table>
<p class="pagination"><%= pagination_links_full @topic_pages, @topic_count %></p>
<% else %>
<p class="nodata"><%= l(:label_no_data) %></p>
<% end %>

<% html_title h(@board.name) %>
