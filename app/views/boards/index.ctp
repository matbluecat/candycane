<h2><%= l(:label_board_plural) %></h2>

<table class="list boards">
  <thead><tr>
    <th><%= l(:label_board) %></th>
    <th><%= l(:label_topic_plural) %></th>
    <th><%= l(:label_message_plural) %></th>
    <th><%= l(:label_message_last) %></th>
  </tr></thead>
  <tbody>
<% for board in @boards %>
  <tr class="<%= cycle 'odd', 'even' %>">
    <td>
      <%= link_to h(board.name), {:action => 'show', :id => board}, :class => "icon22 icon22-comment"  %><br />
      <%=h board.description %>
    </td>
    <td align="center"><%= board.topics_count %></td>
    <td align="center"><%= board.messages_count %></td>
    <td>
    <small>
      <% if board.last_message %>
      <%= authoring board.last_message.created_on, board.last_message.author %><br />
      <%= link_to_message board.last_message %>  
      <% end %>
    </small>
    </td>
  </tr>
<% end %>
  </tbody>
</table>

<p class="other-formats">
<%= l(:label_export_to) %>
<span><%= link_to 'Atom', {:controller => 'projects', :action => 'activity', :id => @project, :format => 'atom', :show_messages => 1, :key => User.current.rss_key},
                          :class => 'feed' %></span>
</p>

<% content_for :header_tags do %>
  <%= auto_discovery_link_tag(:atom, {:controller => 'projects', :action => 'activity', :id => @project, :format => 'atom', :show_messages => 1, :key => User.current.rss_key}) %>
<% end %>

<% html_title l(:label_board_plural) %>
