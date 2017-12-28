<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row ng-hide" ng-hide="loading || newsRecord" ng-cloak>
	<div class="col-xs-12 col-sm-12">
		<div class="well">
			<button type="button" class="btn btn-success" ng-click="get_newsRecord(null);">
				New Article
			</button>
		</div>
	</div>
</div>

<div class="row ng-hide" ng-hide="loading || newsRecord" ng-cloak>
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4" ng-repeat="record in records track by record.id">
		<div class="well fixed-height-140">
			<p><strong>{{record.title}}</strong></p>
			<p>{{record.subtitle}}</p>
			<div class="well-button">
				<button type="button" class="btn btn-success" ng-click="get_newsRecord(record);">
					Edit
				</button>
				<button type="button" class="btn btn-danger" ng-click="delete_newsRecord(record);">
					Delete
				</button>
			</div>
		</div>
	</div>
</div>

<div class="row ng-hide" ng-hide="loading || !newsRecord" ng-cloak>
	<div class="col-xs-12 col-sm-12">
		<div class="well">
			<form class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2">Headline</label>
					<div class="col-sm-10">
						<input type="text" class="form-control"  ng-model="newsRecord.title" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2">Sub Headline</label>
					<div class="col-sm-10">
						<input type="text" class="form-control"  ng-model="newsRecord.subtitle" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12 col-sm-12">
						<div text-angular ta-toolbar="[['p','bold','italics','quote','underline','strikeThrough']]" ng-model="newsRecord.content"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12 col-sm-12">
						<button type="button" class="btn btn-success" ng-click="put_newsRecord();">
							Save
						</button>
						<button type="button" class="btn btn-danger" ng-click="get_news();">
							Cancel
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
/* End of file index.php */
/* Location: ./application/views/news/index.php */