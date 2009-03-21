<div class="contextual">
<%= link_to l(:label_user_new), {:action => 'add'}, :class => 'icon icon-add' %>
</div>

<h2><%=l(:label_user_plural)%></h2>

<% form_tag({}, :method => :get) do %>
<fieldset><legend><%= l(:label_filter_plural) %></legend>
<label><%= l(:field_status) %>:</label>
<%= select_tag 'status', users_status_options_for_select(@status), :class => "small", :onchange => "this.form.submit(); return false;"  %>
<label><%= l(:label_user) %>:</label>
<%= text_field_tag 'name', params[:name], :size => 30 %>
<%= submit_tag l(:button_apply), :class => "small", :name => nil %>
</fieldset>
<% end %>
&nbsp;

<table class="list">		
  <thead><tr>
	<%= sort_header_tag('login', :caption => l(:field_login)) %>
	<%= sort_header_tag('firstname', :caption => l(:field_firstname)) %>
	<%= sort_header_tag('lastname', :caption => l(:field_lastname)) %>
	<%= sort_header_tag('mail', :caption => l(:field_mail)) %>
	<%= sort_header_tag('admin', :caption => l(:field_admin), :default_order => 'desc') %>
	<%= sort_header_tag('created_on', :caption => l(:field_created_on), :default_order => 'desc') %>
	<%= sort_header_tag('last_login_on', :caption => l(:field_last_login_on), :default_order => 'desc') %>
    <th></th>
  </tr></thead>
  <tbody>
<% for user in @users -%>
  <tr class="user <%= cycle("odd", "even") %> <%= %w(anon active registered locked)[user.status] %>">
	<td class="username"><%= avatar(user, :size => "14") %><%= link_to h(user.login), :action => 'edit', :id => user %></td>
	<td class="firstname"><%= h(user.firstname) %></td>
	<td class="lastname"><%= h(user.lastname) %></td>
	<td class="email"><%= mail_to(h(user.mail)) %></td>
	<td align="center"><%= image_tag('true.png') if user.admin? %></td>
	<td class="created_on" align="center"><%= format_time(user.created_on) %></td>
	<td class="last_login_on" align="center"><%= format_time(user.last_login_on) unless user.last_login_on.nil? %></td>
    <td><small><%= change_status_link(user) %></small></td>
  </tr>
<% end -%>
  </tbody>
</table>

<p class="pagination"><%= pagination_links_full @user_pages, @user_count %></p>

<% html_title(l(:label_user_plural)) -%>
