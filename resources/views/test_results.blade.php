<table>
    <thead>
        <tr>
            <th>Test Case ID</th>
            <th>Test Name</th>
            <th>Expected Result</th>
            <th>Actual Result</th>
            <th>Status</th>
            <th>Executed By</th>
            <th>Executed At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $result)
            <tr>
                <td>{{ $result->test_case_id }}</td>
                <td>{{ $result->test_name }}</td>
                <td>{{ $result->expected_result }}</td>
                <td>{{ $result->actual_result }}</td>
                <td>{{ $result->status }}</td>
                <td>{{ $result->executed_by }}</td>
                <td>{{ $result->executed_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
