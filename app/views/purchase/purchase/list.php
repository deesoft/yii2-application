<div class="branch-index">
    <div class="btn-group">
        <a href="#/create" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i></a>
    </div>
    <div class="box box-info">
        <div class="box-body no-padding">
            <div >
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><a href="#">Number</a></th>
                            <th><a href="#">Supplier</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-key="{{model.id}}" ng-repeat="(no,model) in rows">
                            <td><a href="#/view/{{model.id}}">{{no+1}}</a></td>
                            <td>{{model.number}}</td>
                            <td>{{model.supplier_id}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>        
        </div>
    </div>
</div>
