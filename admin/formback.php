<?php
require '../condb.php';

$result = $conn->query("SELECT ss.issue_id,  ss.sid, t.title, u.name, ss.issue_date, ss.tid, ss.uid, ss.comment, ss.file,
                            ((DATEDIFF(DATE_ADD(ss.issue_date, INTERVAL CAST(t.timespan AS UNSIGNED) DAY), CURDATE()) * 100.0) / 
                            CAST(t.timespan AS UNSIGNED)) AS timespan_percentage, 
                            (DATEDIFF(DATE_ADD(ss.issue_date, INTERVAL CAST(t.timespan AS UNSIGNED) DAY), CURDATE())) AS timespan, 
                            s.status 
                        FROM issue ss 
                        JOIN title t ON ss.tid = t.tid 
                        JOIN users u ON ss.uid = u.uid 
                        JOIN statuss s ON ss.sid = s.sid 
                        WHERE ss.sid = 4
                        ORDER BY 
                            timespan_percentage ASC, 
                            ss.issue_id ASC;");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/Photoroom.png">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body>
    <!-- <?php require 'aside.php'; ?> -->
    <main class="main-content position-relative border-radius-lg ">
        <div class="container ml-5">
            <br>
            <br>
            <h3 style="color: white;">รายการคำร้องที่รอการแก้ไข</h3>
            <div>
                <table class="table table-bordered bg-light">
                    <thead class="thead-dark">
                        <tr>
                            <th>รหัสคำร้อง</th>
                            <th>ชื่อคำร้อง</th>
                            <th>ชื่อผู้ยื่นคำร้อง</th>
                            <th>วันที่ยื่นคำร้อง</th>
                            <th>ไฟล์ที่แนบมากับยื่นคำร้อง</th>
                            <th>สถานะยื่นคำร้อง</th>
                            <th>ระยะเวลาที่เหลือ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT ss.issue_id,  ss.sid,t.title, u.name, ss.issue_date,ss.tid,ss.uid,ss.comment,
                        ((DATEDIFF(DATE_ADD(ss.issue_date, INTERVAL CAST(t.timespan AS UNSIGNED) DAY), CURDATE()) * 100.0) / 
                        CAST(t.timespan AS UNSIGNED)) AS timespan_percentage, 
                        (DATEDIFF(DATE_ADD(ss.issue_date, INTERVAL CAST(t.timespan AS UNSIGNED) DAY), CURDATE())) AS timespan, 
                        ss.file, s.status 
                    FROM issue ss 
                    JOIN title t ON ss.tid = t.tid 
                    JOIN users u ON ss.uid = u.uid 
                    JOIN statuss s ON ss.sid = s.sid 
                    WHERE ss.sid = 4
                    ORDER BY 
                        timespan_percentage ASC, 
                        ss.issue_id ASC;
");


                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $color = '';

                                if ($row['timespan_percentage'] <= 20) {
                                    $color = 'bg-danger text-light';
                                }

                                echo '<tr class="text-center ' . $color . '">';
                                echo "<td>" . $row["issue_id"] . "</td>";
                                echo "<td>" . $row["title"] . "</td>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["issue_date"] . "</td>";
                                echo '<td><a href="' . $row["file"] . '">ดูเอกสาร</a></td>';
                                echo "<td>" . $row["status"] . "</td>";
                                echo "<td>" . $row["timespan"] . " วัน</td>";
                                echo "</tr>";
                            }
                        } else
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel">Comment to User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="commentText" class="form-control" placeholder="Enter your comment here..."></textarea>
                    <input type="hidden" id="filingId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitComment()">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showCommentForm(id) {
            $('#filingId').val(id);
            $('#commentModal').modal('show');
        }

        function submitComment() {
            var filingId = $('#filingId').val();
            var comment = $('#commentText').val();

            $.ajax({
                url: 'sentback.php',
                type: 'POST',
                data: {
                    issue_id: filingId,
                    comment: comment
                },
                success: function(response) {
                    alert('Comment submitted successfully.');
                    $('#commentModal').modal('hide');
                    location.reload();
                },
                error: function(error) {
                    alert('An error occurred while submitting the comment.');
                }
            });
        }
    </script>
</body>

</html>