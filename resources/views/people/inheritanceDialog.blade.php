<div class="modal fade" id="addInheritance" role="dialog" aria-labelledby="addInheritanceTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Schließen">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="addInheritanceTitle">Nachlass hinzufügen</h4>
            </div>
            <form @submit.prevent="storeInheritance"
                  action="{{ route('people.inheritances.store', ['people' => $person->id]) }}"
                  class="form-inline" id="createInheritanceForm" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="entry">Eintrag: </label>
                        <input type="text" class="form-control input-sm" name="entry"
                               ref="createEntryField" v-model="createEntry">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Schließen
                    </button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>
