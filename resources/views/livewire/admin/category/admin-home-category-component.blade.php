<div>
    <div class="container" style="padding: 30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Manage Home Categories
                    </div>
                    <div class="panel-body">
                        @if (Session::has('success_message'))
                            <div class="alert alert-success">
                                {{Session::get('success_message')}}
                            </div>
                        @endif
                        <form class="form-horizontal" wire:submit.prevent="updateHomeCategories">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Choose Categories</label>
                                <div class="col-md-4" wire:ignore>
                                    <select class="select_categories form-control" name="categories[]" wire:model="selected_categories" multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}" @if (in_array($category->id,collect($selected_categories)->toArray())) selected @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Numbers of Products</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control input-md" wire:model="number_of_products">
                                    @error('number_of_products') <span class="text-red-600">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    @if ($selected_categories == [])
                                    <button type="button" class="btn btn-primary disabled">Save</button>
                                    @else
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    @endif

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.select_categories').select2();
            $('.select_categories').on('change',function(e){
                var data = $('.select_categories').select2("val");
                @this.set('selected_categories',data);
            });
        });
    </script>
@endpush
