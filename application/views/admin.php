<h1>Current Project Settings</h1>
<h5>
    <ul>
        <li>Project code: {site_code}</li>
        <li>Site Name: {site_name}</li>
        <li>Site Plug: {site_plug}</li>
        <li>Site URL: {site_link}</li>
    </ul>
</h5>
<br/><span style="color:red">{site_changes}</span><br/>
<h3>Make Changes to the Site</h3>
<form method="post" action="/admin/sitename">
    {field_site_name}
    {submit_site_name}
</form>
<br/>
<form method="post" action="/admin/siteplug">
    {field_site_plug}
    {submit_site_plug}
</form>
<br/>