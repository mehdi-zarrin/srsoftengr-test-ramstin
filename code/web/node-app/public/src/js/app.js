angular.module('queueContents', ['datatables'])
	   .controller('queueController', function queueController(DTOptionsBuilder, DTColumnBuilder) {
			    var vm = this;
			    vm.dtOptions = DTOptionsBuilder.fromSource('/api/getPendings')
			        .withPaginationType('full_numbers');
			    vm.dtColumns = [
			        DTColumnBuilder.newColumn('name').withTitle('Name'),
			        DTColumnBuilder.newColumn('mobno').withTitle('Mobile Number'),
			        DTColumnBuilder.newColumn('email').withTitle('Email')
			    ];
			});