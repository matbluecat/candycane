<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title><%=h @page.pretty_title %></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<style>
body { font:80% Verdana,Tahoma,Arial,sans-serif; }
h1, h2, h3, h4 {  font-family: "Trebuchet MS",Georgia,"Times New Roman",serif; }
ul.toc { padding: 4px; margin-left: 0; }
ul.toc li { list-style-type:none; }
ul.toc li.heading2 { margin-left: 1em; }
ul.toc li.heading3 { margin-left: 2em; }
</style>
</head>
<body>
<%= textilizable @content, :text, :wiki_links => :local %>
</body>
</html>
