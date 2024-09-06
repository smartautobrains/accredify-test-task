<h2>Configure project</h2>
<p>In .env file set up database credentials as it needs and API_URL for API that makes Merkle Proof hash</p>
<b>Before running commands highly recommended to configure and start an API!</b>
<p>Run commands:</p>
<ul>
    <li>to install necessary dependencies: <b>composer install</b></li>
    <li>to create an app key: <b>php artisan key:generate</b></li>
    <li>to migrate database: <b>php artisan migrate</b></li>
</ul>
<h2>Start application</h2>
<p><b>php artisan serve</b></p>
<h2>Usage</h2>
<p>In form-data POST request {url}/api/ place json file as "file" param</p>
<p>Response contain data with issuer name and response code</p>
<p><b>Response code could be:</b></p>
<ul>
    <li>invalid_content - if the file does not exist or has no valid json</li>
    <li>invalid_recipient - if recipient does not contain all necessary fields (name, email)</li>
    <li>invalid_issuer - if issuer does not contain all necessary fields (name, identityProof) or if there is no possibility to get dns record with this identityProof</li>
    <li>invalid_signature - if signature does not contain all necessary fields (type, targetHash), there is an errors with request to API or signature is not valid</li>
    <li>verified - if user passed verification</li>
</ul>
<h2>Possible issues</h2>
<p>If you change configuration files or routes maybe application will need to run <b>php artisan optimize</b></p>
<p>Response invalid_signature could be possible if there are problems with connection to API.</p>
