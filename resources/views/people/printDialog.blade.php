<div class="modal fade" id="addPrint" role="dialog" aria-labelledby="addPrintTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Schließen">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="addPrintTitle">Druck hinzufügen</h4>
            </div>
            <form @submit.prevent="storePrint" id="createPrintForm"
                  action="{{ route('people.prints.store', ['people' => $person->id]) }}"
                  class="form-inline" method="POST">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="entry">Eintrag: </label>
                        <input type="text" class="form-control input-sm" name="entry"
                               ref="createEntryField" v-model="createEntry">
                    </div>
                    <div class="form-group">
                        <label for="year">Jahr: </label>
                        <input type="text" class="form-control input-sm" name="year"
                               v-model="createYear">
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
