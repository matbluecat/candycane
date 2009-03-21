<% changesets.each do |changeset| %>
    <div class="changeset <%= cycle('odd', 'even') %>">
    <p><%= link_to("#{l(:label_revision)} #{changeset.revision}",
                :controller => 'repositories', :action => 'revision', :id => @project, :rev => changeset.revision) %><br />
        <span class="author"><%= authoring(changeset.committed_on, changeset.author) %></span></p>
    <%= textilizable(changeset, :comments) %>
    </div>
<% end %>
