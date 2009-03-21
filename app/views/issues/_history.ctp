<% reply_links = authorize_for('issues', 'edit') -%>
<% for journal in journals %>
  <div id="change-<%= journal.id %>" class="journal">
    <h4><div style="float:right;"><%= link_to "##{journal.indice}", :anchor => "note-#{journal.indice}" %></div>
    <%= content_tag('a', '', :name => "note-#{journal.indice}")%>
		<%= authoring journal.created_on, journal.user, :label => :label_updated_time_by %></h4>
    <%= avatar(journal.user, :size => "32") %>
    <ul>
    <% for detail in journal.details %>
       <li><%= show_detail(detail) %></li>
    <% end %>
    </ul>
    <%= render_notes(journal, :reply_links => reply_links) unless journal.notes.blank? %>
  </div>
  <%= call_hook(:view_issues_history_journal_bottom, { :journal => journal }) %>
<% end %>
