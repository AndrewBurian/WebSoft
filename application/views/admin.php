<h1>Current Project Settings</h1>
<h5>
    <ul>
        <li>Project code: {site_code}</li>
        <li>Site Name: {site_name}</li>
        <li>Site Plug: {site_plug}</li>
        <li>Site URL: {site_link}</li>
    </ul>
</h5>
<br/>
<span style="color:green">{site_changes}</span>
<span style="color:red">{err}</span>
<br/>
<h3>Make Changes to the Site</h3>
<br/>
<table style="width: 100%;">
    <tr>
        <td style="vertical-align: top">
            <form method="post" action="/admin/sitename">
                {field_site_name}
                {submit_site_name}
            </form>
        </td>
        <td style="vertical-align: top">
            <form method="post" action="/admin/siteplug">
                {field_site_plug}
                {submit_site_plug}
            </form>
        <td>
    </tr>
</table>