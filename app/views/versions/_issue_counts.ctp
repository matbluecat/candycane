<form id="status_by_form">
<fieldset>
<legend>
<%= l(:label_issues_by, 
       select_tag('status_by',
                   status_by_options_for_select(criteria),
                   :id => 'status_by_select',
                   :onchange => remote_function(:url => { :action => :status_by, :id => version },
                                                :with => "Form.serialize('status_by_form')"))) %>
</legend>
<% if counts.empty? %>
    <p><em><%= l(:label_no_data) %></em></p>
<% else %>
    <table>
    <% counts.each do |count| %>
    <tr>
        <td width="130px" align="right" >
            <%= link_to count[:group], {:controller => 'issues', 
                                        :action => 'index',
                                        :project_id => version.project,
                                        :set_filter => 1,
                                        :fixed_version_id => version,
                                        "#{criteria}_id" => count[:group]} %>
        </td>
        <td width="240px">
            <%= progress_bar((count[:closed].to_f / count[:total])*100, 
                  :legend => "#{count[:closed]}/#{count[:total]}",
                  :width => "#{(count[:total].to_f / max * 200).floor}px;") %>
        </td>
    </tr>
    <% end %>
    </table>
<% end %>
</fieldset>
</form>
