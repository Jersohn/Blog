<div id="confirmDeleteModal" class="modal fade">
    <div class="modal-dialog" style="display: flex; align-items: center; height: 100%;">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h3 class="modal-title text-light">Confirmation de suppression</h3>
                <button type="button" class="close text-light" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <h5>Êtes-vous sûr de vouloir supprimer
                    ?</h5>
                <small class="text-danger">Notez que cette action est irreversible.</small>

            </div>
            <div class="modal-footer">
                <form method="post">
                    <!-- <input type="hidden" name="item_id"  -->
                    <button type="button" class="btn btn-outline_green" data-dismiss="modal">Annuler</button>
                    <a href="DeleteAdmin.php?id=<?php echo htmlentities($AdminId) ?>" type="submit"
                        class="btn btn-outline-danger"><i class='fas fa-trash'></i></a>
                </form>
            </div>
        </div>
    </div>
</div>