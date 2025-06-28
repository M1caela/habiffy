<section id="tabla">
    <a href="agregar.php"><button class="btn btn-primary">+ Nuevo hábito</button></a>
    <div class="overflow-x-auto">
        <table class="w-full min-w-[500px] border-separate border-spacing-2 border bg-base-300 text-center p-[6px] mb-[6px]">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="border p-5 text-left">Hábito</th>
                    <th class="border p-5 text-left">Frecuencia</th>
                    <th class="border p-5">Días</th>
                    <th class="border p-5">Relevancia</th>
                    <th class="border p-5">Ícono</th>
                </tr>
            </thead>
            <tbody>
                <?php while( $estafila = $result->fetch_array() ) { ?>
                <tr>
                    <td class="border p-5">
                        <input type="checkbox" title="¡Completado!"
                            class="checkbox border-base-200 bg-neutral checked:border-success checked:bg-success checked:text-success-content checked:text-grey checked:line-through checked:italic"
                            name="completado" id="completado_<?= $estafila['id'] ?>"
                            data-id="<?= $estafila['id'] ?>"
                            onchange="marcarCompletado(this,event)"
                            <?= isset($habitosCompletados[$estafila['id']]) ? 'checked' : '' ?>
                        >
                    </td>
                    <th>
                        <a href="editar.php?id=<?php echo $estafila['id']; ?>" class="ml-2 inline-block hover:scale-110 transition cursor-pointer" title="Editar">✏️</a>
                        <button
                            class="ml-2 hover:scale-110 transition cursor-pointer" title="Eliminar" onclick="mostrarConfirmacion({
                                titulo: '¿Eliminar hábito?',
                                mensaje: 'Quitaremos “<?= htmlspecialchars($estafila['habito'], ENT_QUOTES) ?>” de la tabla. Esta acción no se puede deshacer.',
                                onConfirm: () => window.location.href = 'eliminar.php?id=<?= $estafila['id'] ?>'
                            })">
                            ❌
                        </button>
                    </th>
                    <td></td>
                    <td class="border p-5 font-semibold text-left <?= isset($habitosCompletados[$estafila['id']]) ? 'line-through italic text-gray-500' : '' ?>"><?php echo $estafila['habito']; ?></td>
                    <td class="border p-5 text-left <?= isset($habitosCompletados[$estafila['id']]) ? 'line-through italic text-gray-500' : '' ?>"><?php echo $estafila['frecuencia']; ?></td>
                    <td class="border p-5 text-left <?= isset($habitosCompletados[$estafila['id']]) ? 'line-through italic text-gray-500' : '' ?>"><?php echo $estafila['dia']; ?></td>
                    <td class="border p-5 font-medium <?= isset($habitosCompletados[$estafila['id']]) ? 'line-through italic text-gray-500' : '' ?>"><?php echo $estafila['relevancia']; ?></td>
                    <td class="border p-5 text-xl <?= isset($habitosCompletados[$estafila['id']]) ? 'line-through italic text-gray-500' : '' ?>"><?php echo $estafila['icono']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>