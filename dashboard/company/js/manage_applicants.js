$(document).ready(() => {
    $(".btn_hired").each((i,e)=>{
        $(e).click(()=>{
            var id = e.dataset.id;
            var action = e.name == 'hired' ? 2 : 3;
            Swal.fire({
              icon: 'question',
              title: 'Hire?',
              text: 'Do you want to continue this action?',
              showCancelButton: true,
              confirmButtonText: 'Yes',
            }).then((result) => {
              if(result.isConfirmed){
                $.ajax({
                  url : "./routes/manage_applicants.php",
                  method: "post",
                  data : {
                    id : id,
                    action: action
                  },
                  success: (res) => {
                      console.log(res)
                      if(res.success){
                          setTimeout(() => {
                              window.location.href = "?page=hire&sub=applicants"
                          }, 500);
                      }else{
                          Swal.fire(
                              'Failed',
                              `${res.message}`,
                              'error'
                          )
                      }
                  }
                });
              }
            })
        });
    });

    $(".btn_decline").each((i,e)=>{
      $(e).click(()=>{
          var id = e.dataset.id
          Swal.fire({
            icon: 'question',
            title: 'Decline?',
            text: 'Do you want to continue this action?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
          }).then((result) => {
            if(result.isConfirmed){
              $.ajax({
                url : "./routes/manage_applicants.php",
                method: "post",
                data : {
                  id : id,
                  action: 3
                },
                success: (res) => {
                    console.log(res)
                    if(res.success){
                        Swal.fire(
                          'Success',
                          `${res.message}`,
                          'success'
                        )
                        setTimeout(() => {
                            window.location.href = "?page=hire&sub=applicants"
                        }, 500);
                    }else{
                        Swal.fire(
                            'Failed',
                            `${res.message}`,
                            'error'
                        )
                    }
                }
              });
            }
          })
      });
  });
});