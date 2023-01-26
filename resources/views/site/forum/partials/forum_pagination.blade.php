<div class="d-flex justify-content-center paginate-desktop">
    {{ $topics->links() }}
</div>

<div class="d-flex justify-content-center paginate-mobile">
    {{ $topics->links('pagination.custom_pagination') }}
</div>
