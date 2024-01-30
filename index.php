<?php
session_start();



$dsn = "sqlite: data.db";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, null, null, $options);


$errorMessage1 = '';


$query = $pdo->prepare("SELECT * FROM todo");
$query->execute();
$row = $query->fetchAll(PDO::FETCH_ASSOC);


print_r($row);
foreach ($row as $tache){
   echo $tache['id'];
}

if (isset($_POST["submitBtn"])) {
    if (strlen($_POST["todoName"]) > 2) {
        $insertData = $pdo->prepare('INSERT INTO todo(name, expiration) VALUES (:nom, :date)');
        $insertData->execute(['nom' => $_POST["todoName"], 'date' => $_POST["todoDate"]]);

        header("Location: index.php");
        exit;
    } else {
        $errorMessage2 = 'Minimum 2 lettres dans la todo';
    }
}

if (isset($_POST['delete'])) {
    $deleteData = $pdo->prepare('DELETE FROM todo WHERE id = :id ');
    $deleteData->execute(['id' => $_POST['delete']]);

    header('Location: index.php');
    exit;
}

if (isset($_POST['edit'])) {
    $updateData = $pdo->prepare('UPDATE todo SET name = :newName WHERE id = :key ');

    $updateData->execute(['key' => $_POST['edit'] , 'newName' => $_POST['inputChange']]);

    header('Location: index.php');
    exit;
}






function sortName($a, $b): int
{
    return strcmp($a[0], $b[0]);
}

function sortDate($a, $b): int
{
    return strtotime($a[1]) - strtotime($b[1]);
}

if (isset($_GET['sortBtn'])) {
    if (isset($_GET['sort'])) {
        $sortType = $_GET['sort'];


    }
}

if (isset($_POST["upBtn"]) || isset($_POST["downBtn"])) {

    if (isset($_POST["upBtn"])) {
        $todoSelect = $_POST["upBtn"];
        $direction = -1;
    } elseif (isset($_POST["downBtn"])) {
        $todoSelect = $_POST["downBtn"];
        $direction = 1;
    }


    header("location:index.php");
    exit;
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
               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nom
            de ta tache</label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
        <input type="date" name="todoDate"
               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
               placeholder=" " required/>
        <label for="floating_password"
               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Date
            de ta tache</label>
    </div>

    <button type="submit" name="submitBtn"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Submit
    </button>
</form>


<form method="get" class="flex">
    <select name="sort" id="sort"
            class="max-w-md mx-auto bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option selected>trier les todos</option>
        <option value="date">Date</option>
        <option value="A-Z">A-Z</option>
        <option value="Z-A">Z-A</option>
    </select>
    <button type="submit" name="sortBtn"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Submit
    </button>
</form>
<?php if (!empty($errorMessage2)) : ?>
    <div class="bg-red-300 justify-center items-center flex border-red-600 border-2 rounded-lg max-w-md mx-auto mt-12">
        <h1 class="p-3 px-12">
            <?php echo $errorMessage2; ?>
        </h1>
    </div>
<?php endif; ?>


<div class="max-w-xl mx-auto mt-12">
    <ul>
        <?php foreach ($row as $tache): ?>

            <li class="mb-12 rounded-lg">
                <div class="flex align-middle flex-row justify-between">
                    <form method="post" class="flex">
                        <div class="">
                            <input name="inputChange" value="<?= htmlspecialchars($tache['name']); ?>"></input>
                        </div>
                        <div class=" w-24 ml-12">
                            <p><?= $tache['expiration']; ?></p>
                        </div>
                        <button name="edit" type="submit"
                                class="flex text-green-500 border-2 border-green-500 ml-12 p-2 rounded-lg" value="<?= $tache['id']; ?>"
                            <svg class="h-6 w-6 text-green-500" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="15" y1="9" x2="9" y2="15"/>
                                <line x1="9" y1="9" x2="15" y2="15"/>
                            </svg>
                            <span>edit</span>
                        </button>

                        <button name="delete" type="submit"
                                class="flex text-red-500 border-2 border-red-500 p-2 rounded-lg ml-12"
                                value="<?= $tache['id']; ?>"
                            <svg class="h-6 w-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="15" y1="9" x2="9" y2="15"/>
                                <line x1="9" y1="9" x2="15" y2="15"/>
                            </svg>
                            <span>Remove</span>
                        </button>

                        <button type="submit" class=" ml-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" name="downBtn" value="<?= $tache['id']; ?>">Down</button>
                        <button type="submit" class=" ml-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" name="upBtn" value="<?= $tache['id']; ?>">Up</button>
                    </form>
                </div>
                <hr class="mt-2"/>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

</body>
</html>