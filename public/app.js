(function () {
    
    var self = this;
    
    var scopes = [
        {
            path : '/index/get-user',
            init : function () {
                
                var me = this;
                
                $('tbody').on('click', '.btn-edit', me.edit.getForm);
                
                $('tbody').on('click', '.btn-remove', me.edit.remove);
                 
                $('tbody').on('click', '.btn-save', me.edit.save);
                
            }
            ,
            edit : {
                field: [
                    'login',
                    'first_name',
                    'last_name',
                    'admin',
                    'ban',
                    'password'
                ]
                ,
                remove: function () {
                    
                    var $tr =  $(this).parents('tr');
                    
                    $.post('/index/remove-user', {user_id: $tr.data('id')}, function (response) {
                        
                        if (undefined !== response['error']) {
                            alert(response['error']);
                            return;
                        }
                        
                        $tr.remove();
                        
                    }, 'json');
                    
                }
                ,
                getForm: function () {
                    var me  = self.scope.edit;
                    
                    var $tr = $(this).parents('tr');
                    
                    var nUserID = $(this).parents('tr').data('id');
                    
                    $.post('/index/get-user-edit-form', {'user_id': nUserID}, function (response) {
                        
                        $tr.replaceWith( $(response) );
                        
                    }, 'html');
                    
                }
                ,
                save : function () {
                    
                    var me  = self.scope.edit;
                    
                    var $tr = $(this).parents('tr');
                    
                    var objUser = {
                        'user_id' : $tr.data('id'),
                    };
                    
                    for (var i in me.field) {
                        var sField = me.field[i];
                        var sValue = $tr.find('[name="' + sField + '"]').val().trim();
                        
                        if (sValue.length === 0) {
                            alert('All fields must be filled up!');
                            return;
                        }
                        
                        objUser[sField] = sValue;
                        
                    }
                    
                    $.post('/index/edit-user', objUser, function (response) {
                        
                        if (undefined !== response['error']) {
                            alert(response['error']);
                            return;
                        }
                        
                        $tr.data('id', response['id']);
                        
                        me.getRow($tr);
                        
                    }, 'json');
                    
                }
                ,
                getRow: function ($tr) {
                    
                    $.post('/index/get-user-list-row', {'user_id' : $tr.data('id')}, function (response) {
                        
                        $tr.replaceWith($(response));
                        
                    }, 'html');
                    
                }
                
            }
        }
        ,
        {
            path : '/index/profile',
            init : function () {
                var me = this;
                $('.btn-user-edit').click(me.edit.switchmode);
                
            }
            ,
            edit : {
                field: [
                    'login',
                    'first_name',
                    'last_name',
                    'password'
                ]
                ,
                switchmode: function () {
                    var me = self.scope.edit;
                    
                    var bShow = $(this).data('edit-mode') == 0;
                    
                    me.field.forEach(function (name) {
                        
                        var $colsm = $('[name="' + name + '"]').parents('.form-group').find('.col-sm-10');
                        var bInvert = bShow;
                        $colsm.each(function(){
                            $(this)[bInvert ? 'hide' : 'show']();
                            bInvert = !bInvert;
                        });
                        
                    });
                    
                    $(this).data('edit-mode', bShow ? 1 : 0);
                    $(this).text(bShow ? 'Save' : 'Edit');
                    
                    if (! bShow) {
                        me.save();
                    }
                    
                }
                ,
                save : function () {
                    
                    var me = self.scope.edit;
                    
                    $.post(window.location.origin + '/index/edit-user', $('.form-edit-user').serialize(), function (response) {
                        
                        if (undefined !== response['error']) {
                            alert(response['error']);
                            return;
                        }
                        
                        me.field.forEach(function (name) {
                            
                            if (name == 'password') {
                                return;
                            }
                            var $colsm = $('[name="' + name + '"]').parents('.form-group').find('.col-sm-10').first();
                            $colsm.find('p').text(response[name]);
                            
                        });
                        
                        
                    }, 'json');
                    
                }
                
            }
        }
        ,
        {
            path : '/index/get-user-message',
            init : function () {
                
                var me = this;
                
                $('.btn-send-message').click(function () {
                    
                    if (! me.message.validate()) {
                        return;
                    }
                    
                    me.message.post();
                    
                });
                
                $('[name="message"]').keydown(function(event){
                    if (event.keyCode == 13) {
                        event.preventDefault();
                        
                        if (! me.message.validate()) {
                            return;
                        }
                        
                        me.message.post();
                        
                        return false;
                    }
                });
                
                $('.btn-update-message-list').click(function(){
                    me.message.getList();
                });
                
                setTimeout(me.message.markReaded, 2000);
                
                setInterval(me.message.getList, 60 * 10000);
                // setInterval(me.message.getList, 10000);
                
            }
            ,
            message : {
                validate : function () {
                    return $('[name="message"]').val().length > 0;
                }
                ,
                post : function () {
                    $.post('/index/post-message', $('.form-post-messsage').serialize(), this.onPostComplete, 'json');
                }
                ,
                onPostComplete : function (response) {
                    
                    if (undefined !== response['error']) {
                        
                        alert(response['error']);
                        
                    } else {
                        
                        $('.table-message-list tbody').append(response['row']);
                        
                        $('[name="message"]').val('');
                        
                    }
                    
                }
                ,
                getList : function () {
                    
                    $.post('/index/get-user-message-list', {user_id : $('[name="user_id"]').val()}, function(response){
                        
                        $('.table-message-list tbody').html(response);
                        
                    }, 'html');
                    
                }
                ,
                markReaded : function () {
                    
                    $.post('/index/read-message', {user_id : $('[name="user_id"]').val()}, function (response) {
                        
                        $('.table-message-list tbody').html(response['list']);
                        
                    }, 'json');
                    
                }
                
            }
        }
    ];
    
    $(document).ready(function() {
        
        scopes.forEach(function (scope) { 
            if (scope.path === window.location.pathname) {
                self.scope = scope;
                self.scope.init();
            }
        });
        
    });
    
})();
