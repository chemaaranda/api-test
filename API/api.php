<?php
 /*

Code  Description Cause
200 OK  Success
400 Bad Request Unsupported or invalid parameters, or missing required parameters.
401 Unauthorized  User is not authorized.
403 Forbidden User does not have access to this resource.
404 Not Found No matching pattern for incoming URI.
405 Method Not Allowed  The service does not support the HTTP method used by the client.
406 Unacceptable Type Unable to provide content type matching the client's Accept header.
412 Precondition Failed A non-syntactic part of the request was rejected. For example, an empty POST or PUT body.
415 Unsupported Media Type  A PUT or POST payload cannot be accepted.


/v1/alert/match (GET) Retrieve a list of rules (including the rule metadata) that match documents identified by a query or a list of URIs.
/v1/alert/match (POST)  Retrieve a list of rules (including the rule metadata) that match either documents in the database identified by a document selection query defined in the request body or a transient document supplied in the request body.
/v1/alert/rules (GET) Retrieve the definition of all alert rules previously installed in this REST API instance using the /v1/alert/{name} service.
/v1/alert/rules/{name} (DELETE) Delete an alerting rule previously installed using PUT /v1/alert/rules/{name}.
/v1/alert/rules/{name} (GET)  Retrieve the alerting rule definition installed with the given name.
/v1/alert/rules/{name} (HEAD) Test for the existence of a rule with the given name.
/v1/alert/rules/{name} (PUT)  Install an alerting rule under the given name.
/v1/config/indexes (GET)  Request a report on whether or not the database configuration includes index configurations that satisfy all installed query options.
/v1/config/indexes/{name} (GET) Request a report on whether or not the database configuration includes index configurations that satisfy these named query options.
/v1/config/namespaces (DELETE)  Remove all installed namespace bindings.
/v1/config/namespaces (GET) List all namespace bindings configured for use in queries, ordered alphabetically by prefix.
/v1/config/namespaces (POST)  Create or append to namespace bindings that can be used in subsequent query operations.
/v1/config/namespaces (PUT) Create or replace namespace bindings that can be used in subsequent query operations.
/v1/config/namespaces/{prefix} (DELETE) Remove the namespace binding for {prefix}.
/v1/config/namespaces/{prefix} (GET)  Retrieve the namespace URI associated with the REST service namespace binding prefix {prefix}.
/v1/config/namespaces/{prefix} (PUT)  Create or modify a namespace binding.
/v1/config/properties (DELETE)  Reset all MarkLogic REST API instance configuration properties to their default values.
/v1/config/properties (GET) Retrieve a list of all MarkLogic REST API instance configuration properties names and settings.
/v1/config/properties (PUT) Set or modify MarkLogic REST API instance configuration properties.
/v1/config/properties/{property-name} (DELETE)  Reset the MarkLogic REST API instance configuration property {property-name} to its default value.
/v1/config/properties/{property-name} (GET) Retrieve the value of the MarkLogic REST API instance configuration property named by {property-name}.
/v1/config/properties/{property-name} (PUT) Set the value of the MarkLogic REST API instance configuration property named by {property-name}.
/v1/config/query (DELETE) Remove all named query options.
/v1/config/query (GET)  Retrieve a list of all the named query options available for use with the service.
/v1/config/query/(default|{name}) (DELETE)  Remove the named (or default) query options from the App Server.
/v1/config/query/(default|{name}) (GET) Retrieve the query options whose name matches the name in the request URI, or retrieve the default query options.
/v1/config/query/(default|{name}) (POST)  Create or append to named query options.
/v1/config/query/(default|{name}) (PUT) Create or replace named query options.
/v1/config/query/(default|{name})/{child-element} (DELETE)  Remove an option setting from the named query options.
/v1/config/query/(default|{name})/{child-element} (GET) Retrieve the setting for a particular option in named query options.
/v1/config/query/(default|{name})/{child-element} (POST)  Add options to existing named query options, or create new named query options if {name} does not already exist.
/v1/config/query/(default|{name})/{child-element} (PUT) Replace options in existing named query options, or create new named query options if {name} does not already exist.
/v1/config/resources (GET)  Retrieve a list of installed resource service extensions, including their metadata.
/v1/config/resources/{name} (DELETE)  Uninstall the named resource service extension.
/v1/config/resources/{name} (GET) Retrieve the XQuery library module or server-side JavaScript module implementing the named resource service extension.
/v1/config/resources/{name} (PUT) Create or update a resource service extension.
/v1/config/transforms (GET) Retrieve metadata about all transforms installed using the /v1/config/transforms/{name} service.
/v1/config/transforms/{name} (DELETE) Remove the named transform.
/v1/config/transforms/{name} (GET)  Retrieve the XQuery, XSLT, or JavaScript implementation installed for the named transform.
/v1/config/transforms/{name} (PUT)  Create or update the named transform.
/v1/documents (DELETE)  Remove documents, or reset document metadata.
/v1/documents (GET) Retrieve document content and/or metadata from the database.
/v1/documents (HEAD)  Returns the same headers as an equivalent GET (content/metadata fetch) on the /documents service.
/v1/documents (PATCH) Perform a partial update to content or metadata of a document.
/v1/documents (POST)  Insert or update content and/or metadata for multiple documents in a single request.
/v1/documents (PUT) Insert or update document contents and/or metadata, at a caller-supplied document URI.
/v1/documents?extension={ext} (POST)  Create a new document with a server-generated database URI.
/v1/documents?uri={db-uri} (POST) Perform a partial update to content or metadata of a document at a caller-specified URI.
/v1/eval (POST) Evaluate an ad-hoc query expressed using XQuery or server-side JavaScript.
/v1/ext/{directories} (DELETE)  Delete the assets in /ext/{directories} in the modules database associated with the REST API instance.
/v1/ext/{directories} (GET) Retrieve a list of assets installed in the modules database associated with a REST API instance, such as a dependent library of an extension or transformation.
/v1/ext/{directories}/{asset} (DELETE)  Remove the asset with document URI /ext/{directories}/{asset} from the modules database associated with this REST API instance.
/v1/ext/{directories}/{asset} (GET) Retrieve an asset installed in the modules database associated with a REST API instance, such as a dependent library of a module implementing an extension or a transformation.
/v1/ext/{directories}/{asset} (PUT) Install an asset such as a dependent library of an extension module in the modules database associated with this REST API instance.
/v1/graphs (DELETE) Remove triples in a named graph or the default graph, or remove all graphs from the triple store.
/v1/graphs (GET)  Retrieve the contents or permissions metadata of a graph, or a list of available graph URIs.
/v1/graphs (HEAD) Returns the same headers as an equivalent GET on the /graphs service.
/v1/graphs (POST) Merge quads into the triple store, or merge other types of triples into a named graph or the default graph.
/v1/graphs (PUT)  Create or replace quads in the triple store; or create or replace other kinds of triples in a named graph or the default graph; or replace the permissions on a named graph or the default graph.
/v1/graphs/sparql (GET) Perform a SPARQL query on the database.
/v1/graphs/sparql (POST)  Perform a SPARQL query or SPARQL Update on one or more graphs.
/v1/graphs/things (GET) Retrieve a list of all graph nodes in the database, or a specified set of nodes.
/v1/invoke (POST) Evaluate an XQuery or server-side JavaScript module installed in MarkLogic Server.
/v1/keyvalue (GET)  THIS METHOD IS DEPRECATED; use /v1/search and /v1/qbe instead.
/v1/qbe (GET) Search the database using a Query By Example or perform a multi-document read for documents that match a Query By Example.
/v1/qbe (POST)  Search the database using a Query By Example or perform a multi-document read for documents that match a Query By Example.
/v1/resources/{name} (DELETE) Send a DELETE request to the named resource service extension.
/v1/resources/{name} (GET)  Make a GET request to the named resource service extension.
/v1/resources/{name} (POST) Applies an extension-specific operation to a resource implemented by a resource service extension.
/v1/resources/{name} (PUT)  Perform the PUT operation associated with a resource service extension.
/v1/rest-apis (GET) Retrieve a list of REST API instances, including configuration details.
/v1/rest-apis (POST)  Create an instance of the MarkLogic REST API, including an HTTP app server, required modules, and optionally a content database.
/v1/rest-apis/{name} (DELETE) Remove an HTTP App Server servicing the MarkLogic REST API.
/v1/rest-apis/{name} (GET)  Retrieve configuration information about an App Server servicing the MarkLogic REST API.
/v1/search (DELETE) Remove documents in a collection or directory, or clear the database.
/v1/search (GET)  Search the database using a string and/or structured query, returning search results and/or matching documents.
/v1/search (POST) Search the database using a structured query, supplied in the POST body; or search the database using a string or structured query with the query options and query combined in the POST body.
/v1/suggest (GET) Retrieve a list of suggested constraint prefixes and/or constraint values that match (complete) the input query text, similar to the XQuery function search:suggest.
/v1/suggest (POST)  Retrieve a list of suggested constraint prefixes and/or constraint values that match (complete) the input query text, similar to the XQuery function search:suggest.
/v1/transactions (POST) Create a multi-statement transaction.
/v1/transactions/{txid} (GET) Retrieve status information for the transaction whose id matches the txid given in the request URI.
/v1/transactions/{txid} (POST)  Commit or rollback the transaction whose id matches the txid given in the request URI.
/v1/values (GET)  Retrieve a list of lexicon configurations available for use with GET /v1/values/{name}.
/v1/values/{name} (GET) Query the values in a lexicon or range index, or find co-occurrences of values in multiple range indexes.
/v1/values/{name} (POST)  Query the values in a lexicon or range index, or find co-occurrences of values in multiple range indexes.


 */
// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);
 
// connect to the mysql database
$link = mysqli_connect('localhost', '··············', '···············', '················');
mysqli_set_charset($link,'utf8');
 
// retrieve the table and key from the path
$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$key = array_shift($request)+0;
 
// escape the columns and values from the input object
$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
$values = array_map(function ($value) use ($link) {
  if ($value===null) return null;
  return mysqli_real_escape_string($link,(string)$value);
},array_values($input));
 
// build the SET part of the SQL command
$set = '';
for ($i=0;$i<count($columns);$i++) {
  $set.=($i>0?',':'').'`'.$columns[$i].'`=';
  $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
}
 
// create SQL based on HTTP method
switch ($method) {
  case 'GET':
    $sql = "select * from `$table`".($key?" WHERE id=$key":''); break;
  case 'PUT':
    $sql = "update `$table` set $set where id=$key"; break;
  case 'POST':
    $sql = "insert into `$table` set $set"; break;
  case 'DELETE':
    $sql = "delete `$table` where id=$key"; break;
}
 
// excecute SQL statement
$result = mysqli_query($link,$sql);
 
// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error());
}
 
// print results, insert id or affected row count
if ($method == 'GET') {
  if (!$key) echo '[';
  for ($i=0;$i<mysqli_num_rows($result);$i++) {
    echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
  }
  if (!$key) echo ']';
} elseif ($method == 'POST') {
  echo mysqli_insert_id($link);
} else {
  echo mysqli_affected_rows($link);
}
 
// close mysql connection
mysqli_close($link);