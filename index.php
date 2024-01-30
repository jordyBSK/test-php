<?php
$todos = [];

if (file_exists('todos.json')) {
    $todos = json_decode(file_get_contents('todos.json'), true);
}

if (isset($_POST["submitBtn"])) {

    $newTodo = [$_POST["todoName"], $_POST["todoDate"]];

    $todos[] = $newTodo;

    file_put_contents('todos.json', json_encode($todos));

    header("location:index.php");
}
if (isset($_POST["delete"])) {

    array_splice($todos, $_POST["delete"],1);

    file_put_contents('todos.json', json_encode($todos));

    header("location:index.php");
}

if (isset($_POST["edit"]) && isset($_POST["inputChange"])) {
    $editIndex = $_POST["edit"];
    $inputValue = $_POST["inputChange"];


    if (array_key_exists($editIndex, $todos)) {

        $todos[$editIndex][0] = $inputValue;
        file_put_contents('todos.json', json_encode($todos));

        header("location:index.php");
        exit;
    }
}



if (isset($_POST['filter'])){

}

if (isset($_POST['sort'])){

}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>




<form class="max-w-md mx-auto mt-12" method="post">
    <div class="relative z-0 w-full mb-5 group">
        <input type="text" name="todoName"
               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
               placeholder=" " required/>
        <label for="floating_email"
               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">nom
            de ta tache</label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
        <input type="date" name="todoDate"
               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
               placeholder=" " required/>
        <label for="floating_password"
               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">date
            de ta tache</label>
    </div>


    <button type="submit" name="submitBtn"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Submit
    </button>
</form>

<div class="max-w-lg mx-auto mt-12">
    <ul>
        <?php foreach ($todos as  $key => $value): ?>
            <li class="p-2 rounded-lg">
                <div class="flex align-middle flex-row justify-between">
                    <div class="p-2">
                        <p> <?php echo htmlspecialchars($value[0]); ?></p>
                    </div>
                    <div class="p-2">
                        <p> <?php echo $value[1]; ?></p>
                    </div>
                    <form action="index.php" method="post" class="flex">
                        <button name="delete" type="submit" class="flex text-red-500 border-2 border-red-500 p-2 rounded-lg" value="<?= $key?>" >
                            <svg class="h-6 w-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                            <span>Remove</span>
                        </button>
                    </form>
                    <form method="post" class="flex">
                        <button name="edit" type="submit" class="flex text-green-500 border-2 border-green-500 p-2 rounded-lg" value="<?= $key?>" >
                            <svg class="h-6 w-6 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                            <span>edit</span>
                        </button>
                        <input type="text" name="inputChange"
                               class="block py-2.5 px-0 w-16 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                    </form>
                </div>
                <hr class="mt-2"/>
            </li>
        <?php endforeach; ?>
    </ul>
</div>


</body>
</html>
