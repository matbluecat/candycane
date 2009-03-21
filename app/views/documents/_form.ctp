<%= error_messages_for 'document' %>
<div class="box">
<!--[form:document]-->
<p><label for="document_category_id"><%=l(:field_category)%></label>
<%= select('document', 'category_id', Enumeration.get_values('DCAT').collect {|c| [c.name, c.id]}) %></p>

<p><label for="document_title"><%=l(:field_title)%> <span class="required">*</span></label>
<%= text_field 'document', 'title', :size => 60 %></p>

<p><label for="document_description"><%=l(:field_description)%></label>
<%= text_area 'document', 'description', :cols => 60, :rows => 15, :class => 'wiki-edit' %></p>
<!--[eoform:document]-->
</div>

<%= wikitoolbar_for 'document_description' %>
