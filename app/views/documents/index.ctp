<div class="contextual">
<%= link_to_if_authorized l(:label_document_new),
                          {:controller => 'documents', :action => 'new', :project_id => @project},
                          :class => 'icon icon-add',
                          :onclick => 'Element.show("add-document"); return false;' %>
</div>

<div id="add-document" style="display:none;">
<h2><%=l(:label_document_new)%></h2>
<% form_tag({:controller => 'documents', :action => 'new', :project_id => @project}, :class => "tabular", :multipart => true) do %>
<%= render :partial => 'documents/form' %>
<div class="box">
<p><label><%=l(:label_attachment_plural)%></label><%= render :partial => 'attachments/form' %></p>
</div>
<%= submit_tag l(:button_create) %>
<%= link_to l(:button_cancel), "#", :onclick => 'Element.hide("add-document")' %>
<% end %>
</div>

<h2><%=l(:label_document_plural)%></h2>

<% if @grouped.empty? %><p class="nodata"><%= l(:label_no_data) %></p><% end %>

<% @grouped.keys.sort.each do |group| %>
    <h3><%= group %></h3>
    <%= render :partial => 'documents/document', :collection => @grouped[group] %>
<% end %>

<% content_for :sidebar do %>
    <h3><%= l(:label_sort_by, '') %></h3>
    <% form_tag({}, :method => :get) do %>
    <label><%= radio_button_tag 'sort_by', 'category', (@sort_by == 'category'), :onclick => 'this.form.submit();' %> <%= l(:field_category) %></label><br />
    <label><%= radio_button_tag 'sort_by', 'date', (@sort_by == 'date'), :onclick => 'this.form.submit();' %> <%= l(:label_date) %></label><br />
    <label><%= radio_button_tag 'sort_by', 'title', (@sort_by == 'title'), :onclick => 'this.form.submit();' %> <%= l(:field_title) %></label><br />
    <label><%= radio_button_tag 'sort_by', 'author', (@sort_by == 'author'), :onclick => 'this.form.submit();' %> <%= l(:field_author) %></label>
    <% end %>
<% end %>

<% html_title(l(:label_document_plural)) -%>
