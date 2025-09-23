

{{-- EDIT --}}

{{-- DETAIL --}}
<div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-labelledby="DetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="userName" class="form-label">Nama: {{ $item->name }}</label>
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label">Email: {{ $item->email }}</label>
                </div>
                <div class="mb-3">
                    <label for="userLevel" class="form-label">Level: {{ $item->role->level }}</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>