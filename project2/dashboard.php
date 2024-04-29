<?php include "frontend/layouts/header.php"; ?>

<?php include "frontend/layouts/sidebar.php"; ?>


        <div class="content">
            <h2>User Table</h2>
            <button class="add-new-button">Add New</button>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody id="tablebody">
                    <tr>
                        
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        fetch('http://localhost//pc113/project2/backend/route/all.php')
.then(res => res.json())
.then(data => {
    console.log(data);

    const tablebody = document.getElementById('tablebody'); 

    tablebody.innerHTML = '';

    for(let i = 0; i < data.length; i++)
    {
        const body = `<td>${data[i].id}</td>        
                      <td>${data[i].role}</td>        
                      <td>${data[i].name}</td>        
                      <td>${data[i].email}</td> 
                      <td>
                        <button class="edit-button">
                            <i class="fas fa-edit"></i> <!-- Font Awesome edit icon -->
                        </button>

                        <button class="delete-button">
                            <i class="fas fa-trash-alt"></i> <!-- Font Awesome delete icon -->
                        </button>
                    </td>       
                   `;
            tablebody.innerHTML += body;
    }
})
.catch(error => console.error('error', error));
    </script>
</body>
</html>
