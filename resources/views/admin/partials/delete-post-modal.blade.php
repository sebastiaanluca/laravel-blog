<div class="modal" id="delete-post-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            
            {!! Form::open(['route' => ['blog::admin.posts.destroy', $post->id]]) !!}
            {{ method_field('DELETE') }}
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Delete post?</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this post? You will not be able to recover it in the future.</p>
                <p><span class="fa fa-info-circle margin-right-xxs"></span>Considering unpublishing it by marking it as a draft instead.</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-block">Delete</button>
            </div>
            
            {!! Form::close() !!}
        </div>
    </div>
</div>