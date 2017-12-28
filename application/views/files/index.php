<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row ng-hide" ng-hide="loading || fileData || fileUpload" ng-cloak>
	<div class="col-xs-12 col-sm-12" ng-class="(fileUploadAvailable ? ' col-md-9 col-lg-9' : ' col-md-12 col-lg-12')">
		<div class="well fixed-height-140">
			<form class="form-horizontal" role="form">
				<div class="form-group" ng-hide="filterClients.length == 1">
					<label for="filter_clientName" class="control-label col-xs-12 col-sm-2">Clients</label>
					<div class="col-xs-12 col-sm-10">
						<div class="input-group">
							<select class="form-control" ng-options="client as client.clients_name for client in filterClients track by client.clients_id" ng-model="filterClientsModel" ng-change="get_files();"></select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="filter_clientName" class="control-label col-xs-12 col-sm-2">File Type</label>
					<div class="col-xs-12 col-sm-10">
						<div class="input-group">
							<select class="form-control" ng-options="tag as tag.name for tag in filterTags track by tag.id" ng-model="filterTagsModel" ng-change="get_files();"></select>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" ng-hide="!fileUploadAvailable">
		<div class="well fixed-height-140 text-center">
			<button type="button" class="btn btn-success btn-lg" ng-click="get_fileUpload()">
				<p><span class="fa fa-cloud-upload fa-2x"></span></p>
				<p class="text-xs">Add New File(s)</p>
			</button>
		</div>
	</div>
</div>

<div class="row ng-hide" ng-hide="loading || fileData || fileUpload" ng-cloak>
	<div class="col-xs-12">
		<div ng-repeat="(key, files) in records">
			<h2>{{key}}</h2>
			<div class="row">
				<div class="well">
					<table class="table table-bordered table-striped table-condensed">
						<thead>
							<tr>
								<th ng-hide="filterClientsModel.clients_id >= 1">Client</th>
								<th class="col-sm-4">File Name</th>
								<th class="col-sm-2">File Date</th>
								<th class="col-sm-1">File Size</th>
								<th class="col-sm-1">Download</th>
								<th class="col-sm-1">Details</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="file in files track by file.files_id">
								<td ng-hide="filterClientsModel.clients_id >= 1">{{file.clients_name}}</td>
								<td>{{file.files_name}}</td>
								<td>{{file.files_date}}</td>
								<td>{{file.files_size}}</td>
								<td><a class="btn btn-primary btn-xs" href="/files/get_file/{{file.files_id}}">Download</a></td>
								<td><a class="btn btn-info btn-xs ng-hide" ng-click="get_file(file)" ng-show="recordsDetails">Details</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row ng-hide" ng-hide="loading || !fileData" ng-cloak>
	<div class="col-sm-12">
		<div class="well">
			<h1>{{fileData.file.name}}</h1>
			<div class="row">
				<div class="col-sm-12">
					File Type: 
					<label class="radio-inline" ng-repeat="fileTag in fileData.fileTags track by fileTag.id">
						<input type="radio" ng-model="fileData.file.fileTags_id" ng-value="{{fileTag.id}}"> {{fileTag.name}}
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-3" ng-repeat="broker in fileData.brokers track by broker.brokers_id">
					<div class="well">
						<div class="form-group">
							<div class="col-sm-2">
								<input type="checkbox" ng-model="broker.brokers_hasAccess" ng-true-value="'1'" ng-false-value="'0'" />
							</div>
							<label class="col-sm-10 control-label">{{broker.brokers_name}}</label>
						</div>
					</div>
				</div>
			</div>
			<div>
				<button type="button" class="btn btn-success" ng-click="patch_file()">
					Update
				</button>
				<button type="button" class="btn btn-warning" ng-click="get_files()">
					Close
				</button>
				<button type="button" class="btn btn-danger" ng-click="delete_file()">
					Delete
				</button>
			</div>
		</div>
	</div>
</div>

<div class="row ng-hide" ng-hide="loading || !fileUpload" ng-cloak>
	<div class="col-sm-12">
		<div class="well">
			<div class="row">
				<label for="filter_clientName" class="control-label col-xs-12 col-sm-2">Clients</label>
				<div class="col-xs-12 col-sm-10">
					<div class="input-group">
						<select class="form-control" ng-options="client as client.clients_name for client in uploadClients track by client.clients_id" ng-model="filterUploadClientsModel"></select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-2">
					<strong>File Type </strong>
				</div>
				<div class="col-sm-12 col-sm-10">
					<label class="radio-inline">
						<input type="radio" ng-model="filterUploadfileTags_id" ng-value="1"> Business Plan
					</label>
					<label class="radio-inline">
						<input type="radio" ng-model="filterUploadfileTags_id" ng-value="2"> Presentation
					</label>
					<label class="radio-inline">
						<input type="radio" ng-model="filterUploadfileTags_id" ng-value="3"> Data / Info
					</label>
					<label class="radio-inline">
						<input type="radio" ng-model="filterUploadfileTags_id" ng-value="4"> Administrative
					</label>
				</div>
			</div>
			<div class="row" ng-hide="filterUploadClientsModel.clients_id == 0 || filterUploadfileTags_id == null">
				<div class="col-xs-12 text-center">
					<div ng-file-drop ng-model="files" class="drop-box"  drag-over-class="dragover" ng-multiple="true" allow-dir="true">Drop files here</div>
					<div ng-no-file-drop>File Drag/Drop is not supported for this browser</div>
				</div>
			</div>
			<div class="row" ng-hide="filterUploadClientsModel.clients_id == 0 || filterUploadfileTags_id == null">
				<div class="col-xs-12">
					<h3>File Log</h3>
					<div ng-repeat="log in fileLog">{{log}}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<button type="button" class="btn btn-warning" ng-click="get_files()">
						Close
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
/* End of file index.php */
/* Location: ./application/views/files/index.php */
