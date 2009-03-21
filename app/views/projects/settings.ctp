<h2><%=l(:label_settings)%></h2>

<% tabs = project_settings_tabs %>
<% selected_tab = params[:tab] ? params[:tab].to_s : tabs.first[:name] %>

<div class="tabs">
<ul>
<% tabs.each do |tab| -%>
    <li><%= link_to l(tab[:label]), { :tab => tab[:name] },
                                    :id => "tab-#{tab[:name]}",
                                    :class => (tab[:name] != selected_tab ? nil : 'selected'),
                                    :onclick => "showTab('#{tab[:name]}'); this.blur(); return false;" %></li>
<% end -%>
</ul>
</div>

<% tabs.each do |tab| -%>
<%= content_tag('div', render(:partial => tab[:partial]), 
                       :id => "tab-content-#{tab[:name]}",
                       :style => (tab[:name] != selected_tab ? 'display:none' : nil),
                       :class => 'tab-content') %>
<% end -%>

<% html_title(l(:label_settings)) -%>
