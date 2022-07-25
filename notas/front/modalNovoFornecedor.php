  <!-- Modal Novo Fornecedor-->
  <div class="modal fade" id="modalNewFornecedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form id="novofornecedor" method="POST" action="<?php echo $acaomodalnovofornecedor; ?>">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Cadastro de Fornecedor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="cpfcnpj">CPF / CNPJ</label>
              <input type="text" class="form-control" id="cpfcnpj" name="cpfcnpj" maxlength="18" required>
            </div>
            <div class="form-group">
              <label for="nomeFornecedor">Fornecedor</label>
              <input type="text" class="form-control" id="nomeFornecedor" name="nomeFornecedor" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <input type="submit" class="btn btn-success" name="newFornecedor" value="Salvar" />
          </div>
        </form>
      </div>
    </div>
  </div>