<div id="login-form">
<% form_tag({:action=> "login"}) do %>
<%= back_url_hidden_field_tag %>
<table>
<tr>
    <td align="right"><label for="username"><%=l(:field_login)%>:</label></td>
    <td align="left"><p><%= text_field_tag 'username', nil, :size => 40 %></p></td>
</tr>
<tr>
    <td align="right"><label for="password"><%=l(:field_password)%>:</label></td>
    <td align="left"><%= password_field_tag 'password', nil, :size => 40 %></td>
</tr>
<tr>
    <td></td>
    <td align="left">
        <% if Setting.autologin? %>
        <label for="autologin"><%= check_box_tag 'autologin' %> <%= l(:label_stay_logged_in) %></label>
        <% end %>
    </td>
</tr>
<tr>
    <td align="left">
        <% if Setting.lost_password? %>
            <%= link_to l(:label_password_lost), :controller => 'account', :action => 'lost_password' %>
        <% end %>
    </td>
    <td align="right">
        <input type="submit" name="login" value="<%=l(:button_login)%> &#187;" />
    </td>
</tr>
</table>
<%= javascript_tag "Form.Element.focus('username');" %>
<% end %>
</div>
