export default function(str1, str2) {
    let cost = [],
        n = str1.length,
        m = str2.length,
        i, j;

    if (n == 0 || m == 0) {
        return;
    }

    for (i = 0; i <= n; i++) {
        cost[i] = [];
    }

    for (i = 0; i <= n; i++) {
        cost[i][0] = i;
    }

    for (j = 0; j <= m; j++) {
        cost[0][j] = j;
    }

    for (i = 1; i <= n; i++) {
        let x = str1.charAt(i - 1);

        for (j = 1; j <= m; j++) {
            let y = str2.charAt(j - 1);

            if (x == y) {
                cost[i][j] = cost[i - 1][j - 1];
            } else {
                cost[i][j] = 1 + Math.min(cost[i - 1][j - 1], cost[i][j - 1], cost[i - 1][j]);
            }
        }
    }

    return cost[n][m];
}
