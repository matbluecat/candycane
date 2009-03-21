<h2><%= l(:label_settings) %>: <%=h @plugin.name %></h2>

<div id="settings">
<% form_tag({:action => 'plugin'}) do %>
<div class="box tabular">
<%= render :partial => @partial, :locals => {:settings => @settings}%>
</div>
<%= submit_tag l(:button_apply) %>
<% end %>
</div>
