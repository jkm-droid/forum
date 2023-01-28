<div class="d-flex justify-content-center paginate-desktop">
    {{ $category_topics->links() }}
</div>

<div class="d-flex justify-content-center paginate-mobile">
    {{ $category_topics->links('pagination.custom_pagination') }}
</div>
