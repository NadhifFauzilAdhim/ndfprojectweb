<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container my-5">
        <h1 class="text-center fw-bold">API Documentation</h1>
        <p class="text-center">Base URL: <code>https://ndfproject.my.id/api/</code></p>
        <section id="api-description">
            <h2>API Overview</h2>
            <p>This API is designed for managing shortened links and tracking their performance. It provides various endpoints to create, update, retrieve, and delete links, as well as monitor link activities such as visits, unique visits, and blocked IPs. Additionally, it supports link protection features like password protection, with full control over the links' visibility and status. Whether you're managing a collection of links or analyzing their traffic, this API offers all the necessary functionality for efficient link management and tracking.</p>
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                <div>
                    <img src="https://i.ibb.co.com/p4SYDhQ/1.png" alt="Image 1" style="max-width: 100%; height: auto;"/>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12  mt-2">
                <div>
                    <img src="https://i.ibb.co.com/RvJsXZT/2.png" alt="Image 2" style="max-width: 100%; height: auto;"/>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12  mt-2">
                <div>
                    <img src="https://i.ibb.co.com/Zm0ygwV/3.png" alt="Image 3" style="max-width: 100%; height: auto;"/>
                </div>
            </div>
          </div>
          <a href="https://ndfproject.my.id/dashboard/link" class="btn btn-primary mt-2">Go to Apps</a>
        </section>
        
        <section id="authentication" >
            <h2>Authentication</h2>
            <p>The API uses token-based authentication with Sanctum.</p>
            <div class="accordion" id="authenticationAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingRegister">
                        <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseRegister" aria-expanded="true" aria-controls="collapseRegister">
                            Register
                        </button>
                    </h2>
                    <div id="collapseRegister" class="accordion-collapse collapse show" aria-labelledby="headingRegister" data-bs-parent="#authenticationAccordion">
                        <div class="accordion-body">
                            <strong>Endpoint:</strong> <code>/register</code><br>
                            <strong>Method:</strong> POST<br>
                            <strong>Description:</strong> Registers a new user.<br>
                            <pre><code>{
"name": "string",
"username": "string",
"email": "string",
"password": "string"
}</code></pre>
                            <strong>Response:</strong>
                            <ul>
                                <li><code>201</code> Created on success</li>
                                <li><code>422</code> Unprocessable Entity on validation failure</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingLogin">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLogin" aria-expanded="false" aria-controls="collapseLogin">
                            Login
                        </button>
                    </h2>
                    <div id="collapseLogin" class="accordion-collapse collapse" aria-labelledby="headingLogin" data-bs-parent="#authenticationAccordion">
                        <div class="accordion-body">
                            <strong>Endpoint:</strong> <code>/login</code><br>
                            <strong>Method:</strong> POST<br>
                            <strong>Description:</strong> Logs in a user.<br>
                            <pre><code>{
  "email": "string",
  "password": "string"
}</code></pre>
<strong>Response:</strong>
<ul>
    <li><code>200</code> OK on success:
        <pre><code>
{
    "success": boolean,
    "message": "string",
    "access_token": "string",
    "token_type": "Bearer",
    "user": {
        "id": "integer",
        "email": "string",
        "name": "string",
        "username": "string",
        "avatar": "string|null"
    }
}
        </code></pre>
    </li>
    <li><code>401</code> Unauthorized on failure:
        <pre><code>
{
    "message": "The provided credentials are incorrect."
}
        </code></pre>
    </li>
</ul>

                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingLogout">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLogout" aria-expanded="false" aria-controls="collapseLogout">
                            Logout
                        </button>
                    </h2>
                    <div id="collapseLogout" class="accordion-collapse collapse" aria-labelledby="headingLogout" data-bs-parent="#authenticationAccordion">
                        <div class="accordion-body">
                            <strong>Endpoint:</strong> <code>/logout</code><br>
                            <strong>Method:</strong> POST<br>
                            <strong>Description:</strong> Logs out the authenticated user.<br>
                            <strong>Headers:</strong> <code>Authorization: Bearer {token}</code><br>
                            <strong>Response:</strong>
                            <ul>
                                <li><code>200</code> OK on success</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="links" >
            <h2>Links</h2>
            <div class="accordion" id="linksAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingGetLinks">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGetLinks" aria-expanded="true" aria-controls="collapseGetLinks">
                            Get Links
                        </button>
                    </h2>
                    <div id="collapseGetLinks" class="accordion-collapse collapse show" aria-labelledby="headingGetLinks" data-bs-parent="#linksAccordion">
                        <div class="accordion-body">
                            <strong>Endpoint:</strong> <code>/links</code><br>
                            <strong>Method:</strong> GET<br>
                            <strong>Description:</strong> Retrieves a paginated list of links created by the authenticated user.<br>
                            <strong>Headers:</strong> <code>Authorization: Bearer {token}</code><br>
                            <strong>Query Parameters:</strong>
                            <ul>
                                <li><code>search</code> (optional): Filter links by slug.</li>
                            </ul>
                            <strong>Response:</strong>
                            <pre><code>{
  "success" : "boolean",                      
  "totalLinks": "integer",
  "totalVisit": "integer",
  "totalUniqueVisit": "integer",
  "links": { "data": [...] },
  "topLinks": [...]
}</code></pre>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingCreateLink">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCreateLink" aria-expanded="false" aria-controls="collapseCreateLink">
                            Create Link
                        </button>
                    </h2>
                    <div id="collapseCreateLink" class="accordion-collapse collapse" aria-labelledby="headingCreateLink" data-bs-parent="#linksAccordion">
                        <div class="accordion-body">
                            <strong>Endpoint:</strong> <code>/links</code><br>
                            <strong>Method:</strong> POST<br>
                            <strong>Description:</strong> Creates a new link.<br>
                            <strong>Headers:</strong> <code>Authorization: Bearer {token}</code><br>
                            <pre><code>{ 
  "success" : "boolean",
  "target_url": "string",
  "slug": "string",
  "password_protected": "boolean",
  "password": "string (optional)",
  "active": "boolean"
}</code></pre>
                            <strong>Response:</strong>
                            <ul>
                                <li><code>201</code> Created on success: <pre><code>{"message": "Link created successfully.", "link": {...}}</code></pre></li>
                                <li><code>422</code> Unprocessable Entity on validation failure</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingGetLinkDetails">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGetLinkDetails" aria-expanded="false" aria-controls="collapseGetLinkDetails">
                            Get Link Details
                        </button>
                    </h2>
                    <div id="collapseGetLinkDetails" class="accordion-collapse collapse" aria-labelledby="headingGetLinkDetails" data-bs-parent="#linksAccordion">
                        <div class="accordion-body">
                            <strong>Endpoint:</strong> <code>/links/{id}</code><br>
                            <strong>Method:</strong> GET<br>
                            <strong>Description:</strong> Retrieves details of a specific link.<br>
                            <strong>Headers:</strong> <code>Authorization: Bearer {token}</code><br>
                            <strong>Query Parameters:</strong>
                            <ul>
                                <li><code>filter</code> (optional): (all, unique, redirected, rejected)</li>
                            </ul>
                            <strong>Response:</strong>
                            <pre><code>{
  "success" : "boolean",
  "link": {...},
  "visithistory": { "data": [...] },
  "redirectedCount": "integer",
  "rejectedCount": "integer",
  "blockedIps": [...],
  "filter": "string",
  "topReferers": [...]
}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingUpdateLink">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUpdateLink" aria-expanded="false" aria-controls="collapseUpdateLink">
                            Update Link
                        </button>
                    </h2>
                    <div id="collapseUpdateLink" class="accordion-collapse collapse" aria-labelledby="headingUpdateLink" data-bs-parent="#linksAccordion">
                        <div class="accordion-body">
                            <strong>Endpoint:</strong> <code>/links/{id}</code><br>
                            <strong>Method:</strong> POST (use <code>_method=PUT</code> in request body)<br>
                            <strong>Description:</strong> Updates an existing link.<br>
                            <strong>Headers:</strong> <code>Authorization: Bearer {token}</code><br>
                            <strong>Request Body:</strong>
                            <pre><code>{
  "success" : "boolean",
  "target_url": "string",
  "slug": "string",
  "password": "string (optional)",
  "password_protected": "boolean",
  "active": "boolean",
  "_method": "PUT"
}</code></pre>
                            <strong>Response:</strong>
                            <pre><code>{
  "message": "Link updated successfully.",
  "link": {...}
}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDeleteLink">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDeleteLink" aria-expanded="false" aria-controls="collapseDeleteLink">
                            Delete Link
                        </button>
                    </h2>
                    <div id="collapseDeleteLink" class="accordion-collapse collapse" aria-labelledby="headingDeleteLink" data-bs-parent="#linksAccordion">
                        <div class="accordion-body">
                            <strong>Endpoint:</strong> <code>/links/{id}</code><br>
                            <strong>Method:</strong> POST (use <code>_method=DELETE</code> in request body)<br>
                            <strong>Description:</strong> Deletes a specific link.<br>
                            <strong>Headers:</strong> <code>Authorization: Bearer {token}</code><br>
                            <strong>Request Body:</strong>
                            <pre><code>{
  "_method": "DELETE"
}</code></pre>
                            <strong>Response:</strong>
                            <pre><code>{
  "message": "Link deleted successfully."
}</code></pre>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Link operations like Get Link Details, Update Link, Delete Link -->
            </div>
        </section>

        <section id="links" >
            <h2>Block Ip</h2>
            <div class="accordion" id="linksAccordion">
                              <div class="accordion-item">
    <h2 class="accordion-header" id="headingGetBlockedIps">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGetBlockedIps" aria-expanded="false" aria-controls="collapseGetBlockedIps">
            Get Blocked IPs
        </button>
    </h2>
    <div id="collapseGetBlockedIps" class="accordion-collapse collapse show" aria-labelledby="headingGetBlockedIps" data-bs-parent="#linksAccordion">
        <div class="accordion-body">
            <strong>Endpoint:</strong> <code>/block-ip/{link_id}</code><br>
            <strong>Method:</strong> GET<br>
            <strong>Description:</strong> Retrieves blocked IPs associated with a specific link ID.<br>
            <strong>Headers:</strong> <code>Authorization: Bearer {token}</code><br>
            <strong>Response:</strong>
            <ul>
                <li><code>200 OK</code> on success: <pre><code>{
"success": true,
"message": "Blocked IPs retrieved successfully.",
"data": [...]
}</code></pre></li>
                <li><code>200 OK</code> if no blocked IPs are found: <pre><code>{
"success": true,
"message": "No blocked IPs found for the given link ID.",
"data": []
}</code></pre></li>
                <li><code>500 Internal Server Error</code> on unexpected error: <pre><code>{
"success": false,
"message": "An unexpected error occurred.",
"error": "string"
}</code></pre></li>
            </ul>
        </div>
    </div>
</div>

<div class="accordion-item">
    <h2 class="accordion-header" id="headingBlockIp">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBlockIp" aria-expanded="false" aria-controls="collapseBlockIp">
            Block an IP Address
        </button>
    </h2>
    <div id="collapseBlockIp" class="accordion-collapse collapse" aria-labelledby="headingBlockIp" data-bs-parent="#linksAccordion">
        <div class="accordion-body">
            <strong>Endpoint:</strong> <code>/block-ip</code><br>
            <strong>Method:</strong> POST<br>
            <strong>Description:</strong> Blocks an IP address for a specific link.<br>
            <strong>Headers:</strong> <code>Authorization: Bearer {token}</code><br>
            <strong>Request Body:</strong>
            <pre><code>{
"ip_address": "string",
"link_id": "integer"
}</code></pre>
            <strong>Response:</strong>
            <ul>
                <li><code>201 Created</code> on success: <pre><code>{
"success": true,
"message": "IP Address blocked successfully.",
"data": {...}
}</code></pre></li>
                <li><code>422 Unprocessable Entity</code> on validation failure: <pre><code>{
"success": false,
"message": "The given data was invalid.",
"errors": { ... }
}</code></pre></li>
                <li><code>500 Internal Server Error</code> on unexpected error: <pre><code>{
"success": false,
"message": "An unexpected error occurred.",
"error": "string"
}</code></pre></li>
            </ul>
        </div>
    </div>
</div>

<div class="accordion-item">
    <h2 class="accordion-header" id="headingUnblockIp">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUnblockIp" aria-expanded="false" aria-controls="collapseUnblockIp">
            Unblock an IP Address
        </button>
    </h2>
    <div id="collapseUnblockIp" class="accordion-collapse collapse" aria-labelledby="headingUnblockIp" data-bs-parent="#linksAccordion">
        <div class="accordion-body">
            <strong>Endpoint:</strong> <code>/block-ip/{id}</code><br>
            <strong>Method:</strong> POST (use <code>_method=DELETE</code> in request body)<br>
            <strong>Description:</strong> Unblocks a specific IP address.<br>
            <strong>Headers:</strong> <code>Authorization: Bearer {token}</code><br>
            <strong>Request Body:</strong>
            <pre><code>{
"_method": "DELETE"
}</code></pre>
            <strong>Response:</strong>
            <ul>
                <li><code>200 OK</code> on success: <pre><code>{
"success": true,
"message": "IP Address unblocked successfully."
}</code></pre></li>
                <li><code>500 Internal Server Error</code> on unexpected error: <pre><code>{
"success": false,
"message": "An unexpected error occurred."
}</code></pre></li>
            </ul>
        </div>
    </div>
</div>

                <!-- Additional Link operations like Get Link Details, Update Link, Delete Link -->
            </div>
        </section>

        <section id="visit-data" >
            <h2>Visit Data</h2>
            <p>Retrieve visit statistics for the authenticated user's links.</p>
            <strong>Endpoint:</strong> <code>/visit-data</code><br>
            <strong>Method:</strong> GET<br>
            <strong>Headers:</strong> <code>Authorization: Bearer {token}</code><br>
            <strong>Response:</strong>
            <pre><code>{
  "visitData": [integer, integer, integer, integer, integer, integer, integer],
  "weeklyVisitData": [integer, integer, integer, integer, integer, integer, integer]
}</code></pre>
            <p>The array represents visit counts for each day of the week, starting with Sunday.</p>
        </section>

        <section id="qr-code" >
            <h2>QR Code</h2>
            <p>Generate a QR code for the provided data.</p>
            <strong>Endpoint:</strong> <code>/qrcode</code><br>
            <strong>Method:</strong> GET<br>
            <strong>Query Parameters:</strong>
            <ul>
                <li><code>data</code> (required): The data to encode in the QR code.</li>
                <li><code>size</code> (optional): Dimensions of the QR code (e.g., 200x200).</li>
            </ul>
            <strong>Response:</strong>
            <pre><code>{
  "success": true,
  "message": "QR Code generated successfully.",
  "qrCodeUrl": "string"
}</code></pre>
        </section>
        
    </div>
</x-layout>