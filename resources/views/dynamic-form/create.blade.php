@extends('layouts.master')
@section('content')
    <div class="container card py-4 ">
        <div class="row my-2">
            <div class="col-md-12 text-center text-dark mx-3 h4">Google Form</div>
        </div>
        
        <form action="{{ route('dynamic_form.store') }}" method="POST">
            <div class=" col-md-6 m-auto my-3">
                <input name="form_name" type="text" placeholder="Enter Your Form Name" required class="form-control " >
            </div>
            @csrf
            <ul class="content drag-sort-enable my-3">

            </ul>

            <div class="row d-flex justify-content-center" id="btn_container">
                <button type="submit" class="btn btn-primary btn-sm mx-1">Submit</button>
                <button type="button" id="addField" class="btn btn-primary btn-sm mx-1">Add Field</button>
            </div>

        </form>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            $("#addField").on('click', function() {
                let total_children = $('.content').children().length;

                let main_content = `
                        <li id="fieldHeader_${total_children}" draggable="true" class=""> 
                            <div class="field row d-flex justify-content-around my-3 " id="field_${total_children}">
                                <div id="field_container_${total_children}" class="row col-md-8 m-auto">
                                    <div id="fieldname_container_${total_children}" class="col-md-12">
                                        <input type='text' placeholder='Field Label'name="fieldname_${total_children}" class='form-control mx-2' value=''/>
                                    </div>
                                    <div class="form-group d-flex justify-content-around  col-md-4 mx-2" id="required_handler_${total_children}">
                                        <button type="button" class="btn btn-sm btn-delete"><i class="fa fa-trash text-danger"></i></button>
                                        <label>Required</label>
                                        <input type='checkbox' class='mx-2 setRequired'  value='${total_children}'/>
                                    </div>
                                    
                                </div>
                                <div id="field_handler_${total_children}" class="col-md-4">
                                    <select id="field_controller_${total_children}"  class="form-control">
                                        @foreach ($fields as $field)
                                            <option value="{{ $field->slug ?? '' }}">{{ $field->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="optionContainer_${total_children}" class="container d-flex justify-content-around col-md-8 my-1"></div>
                            </div>  
                            
                            <div id="type_container">
                                <input type="hidden" name="type_${total_children}" value="short_answer" />    
                            </div>
                        </li>
              `;
 
                let previous_children_dlt_btn = total_children - 1;


                if (total_children !== -1) {
                    $(`#field_handler_${previous_children_dlt_btn}`).attr('class', 'd-none');
                    $(`#required_handler_${previous_children_dlt_btn}`).attr('class', 'd-none');
                    $(`#addMultipleChoice_${previous_children_dlt_btn}`).attr('class', 'd-none');
                    $(`#field_container_${previous_children_dlt_btn}`).attr('class', 'row col-md-12');
                    $(`#field_${previous_children_dlt_btn}`).attr('class', 'field ');
                    
                }
                
                $('.content').append(main_content)
                
                
                $('.btn-delete').on('click', function() {
                    $(`#fieldHeader_${total_children}`).remove();
                    $(`#addMultipleChoice_${total_children}`).remove();
                    $(`#field_handler_${previous_children_dlt_btn}`).attr('class', 'col-md-4');
                    $(`#required_handler_${previous_children_dlt_btn}`).attr('class',
                    'form-group d-flex justify-content-around');
                    $(`#field_${previous_children_dlt_btn}`).attr('class', 'field row d-flex justify-content-around my-3 ');
                    $(`#field_container_${previous_children_dlt_btn}`).attr('class', 'row col-md-8 m-auto'); 

                    

                })

                
                $('.setRequired').on('change', function() {
                    let val = $(this).val();
                    if ($(this).is(':checked')) {

                        let hidden_content =
                            `<input type="hidden" name="hidden_field_${val}" value="fieldname_${val}" />`;
                        $(`#field_${val}`).append(hidden_content);
                    } else {
                        $(`input[name=hidden_field_${val}]`).remove()
                    }
                })


                $(`#field_controller_${total_children}`).on('change', function() {
                    let field = $(this).val();
                    let input_content = null;
                    
                    if(field == 'short_answer'){
                        input_content =  ` <input type='text' placeholder='Field Label'name="fieldname_${total_children}" class='form-control mx-2' value=''/>`;
                        let type = `<input type="hidden" name="type_${total_children}" value="${field}" />`
                        $(`input[name=type_${total_children}]`).remove();
                        $(`#type_container`).append(type);

                    }else if(field == 'long_answer'){
                        input_content = ` <textarea cols="20" rows="2" name="fieldname_${total_children}" class='form-control mx-2'></textarea>`;
                        let type = `<input type="hidden" name="type_${total_children}" value="${field}" />`
                        $(`input[name=type_${total_children}]`).remove();
                        $(`#type_container`).append(type);

                    }else if(field == 'multiple_choice'){
                        input_content = `<input type='text' placeholder='Field Label'name="fieldname_${total_children}" class='form-control mx-2' value=''/>
                                    
                        `;
                        let button = `<button type="button" id="addMultipleChoice_${total_children}" class='btn btn-primary btn-sm'>add option</button>`
                        $(`#btn_container`).append(button)

                        let type = `<input type="hidden" name="type_${total_children}" value="${field}" />`
                        $(`input[name=type_${total_children}]`).remove();
                        $(`#type_container`).append(type);
                       
                    }else if(field == 'checkbox'){
                        input_content = `<input type='text' placeholder='Field Label'name="fieldname_${total_children}" class='form-control mx-2' value=''/>
                                    
                        `;
                        let button = `<button type="button" id="addMultipleChoice_${total_children}" class='btn btn-primary btn-sm'>add option</button>`
                        $(`#btn_container`).append(button)

                        let type = `<input type="hidden" name="type_${total_children}" value="${field}" />`
                        $(`input[name=type_${total_children}]`).remove();
                        $(`#type_container`).append(type);
                       
                    }else if(field == 'dropdown'){
                        input_content = `<input type='text' placeholder='Field Label'name="fieldname_${total_children}" class='form-control mx-2' value=''/>
                                    
                        `;
                        let button = `<button type="button" id="addMultipleChoice_${total_children}" class='btn btn-primary btn-sm'>add option</button>`
                        $(`#btn_container`).append(button)

                        let type = `<input type="hidden" name="type_${total_children}" value="${field}" />`
                        $(`input[name=type_${total_children}]`).remove();
                        $(`#type_container`).append(type);

                       
                    }else if(field == 'date'){
                        input_content =  ` <input type='text' placeholder='Field Label'name="fieldname_${total_children}" class='form-control mx-2' value=''/>`;
                    
                        let type = `<input type="hidden" name="type_${total_children}" value="${field}" />`
                        $(`input[name=type_${total_children}]`).remove();
                        $(`#type_container`).append(type);

                    }else if(field == 'time'){
                        input_content =  ` <input type='text' placeholder='Field Label'name="fieldname_${total_children}" class='form-control mx-2' value=''/>`;
                    
                        let type = `<input type="hidden" name="type_${total_children}" value="${field}" />`
                        $(`input[name=type_${total_children}]`).remove();
                        $(`#type_container`).append(type);

                    }
                    
                    $(`#fieldname_container_${total_children}`).html(input_content);
                    
                    
                        $(`#addMultipleChoice_${total_children}`).on('click',function(){
                            let optionContent = `<div class="d-flex justify-content-center">
                                            <input type='radio' disabled class='setRequired mx-1' />
                                            <input type='text' placeholder='option' class="form-control" name="multiplechoice_${total_children}[]" value=''/>
                                </div>`
                            $(`#optionContainer_${total_children}`).append(optionContent)
                        })
                    

                })

                enableDragSort('drag-sort-enable');

             


            })


        })
    </script>

    <script>


  function enableDragSort(listClass) {
   
    const sortableLists = document.getElementsByClassName(listClass);
    Array.prototype.map.call(sortableLists, (list) => { enableDragList(list) });
  }

  function enableDragList(list) {
    Array.prototype.map.call(list.children, (item) => { enableDragItem(item) });
  }

  function enableDragItem(item) {
    item.setAttribute('draggable', true)
    item.ondrag = handleDrag;
    item.ondragend = handleDrop;
  }

  function handleDrag(item) {
    const selectedItem = item.target,
      list = selectedItem.parentNode,
      x = event.clientX,
      y = event.clientY;

    selectedItem.classList.add('drag-sort-active');
    let swapItem = document.elementFromPoint(x, y) === null ? selectedItem : document.elementFromPoint(x, y);

    if (list === swapItem.parentNode) {
      swapItem = swapItem !== selectedItem.nextSibling ? swapItem : swapItem.nextSibling;
      list.insertBefore(selectedItem, swapItem);
    }
  }

  function handleDrop(item) {
    item.target.classList.remove('drag-sort-active');
  }

  (() => { enableDragSort('drag-sort-enable') })();
</script>
@endpush

@push('css')
    <style>
        ul {
            list-style-type: disc;
        }
       
    </style>
@endpush
