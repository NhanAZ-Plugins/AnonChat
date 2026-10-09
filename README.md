# AnonChat

AnonChat lets players broadcast a message without showing their name to other players.

[![Build](https://github.com/NhanAZ-Plugins/AnonChat/actions/workflows/build.yml/badge.svg)](https://github.com/NhanAZ-Plugins/AnonChat/actions/workflows/build.yml)

## How it works

Type `[*] hello` in chat to broadcast `hello` with the configured anonymous label. A space immediately after `[*]` is optional. Messages without the prefix use normal server chat. An empty prefixed message is ignored.

The plugin cancels the original chat event before broadcasting the replacement. The broadcast does not include the player's name. The server console can include the sender's name when `showMsgToCsl` is enabled. Server operators and other plugins may still be able to identify the sender. This plugin does not provide anonymity from the server.

## Requirements and compatibility

- An Axolotl-PM server with plugin API 5.0.0. The exact server revision used for CI is pinned in the [build workflow](.github/workflows/build.yml).
- PHP 8.1 or newer with the extensions required by Axolotl-PM.

The minimum server patch release has not been established independently. Compatibility across all Axolotl-PM 5.x releases remains unverified. The API declaration in [plugin.yml](plugin.yml) is the plugin's compatibility requirement. It is not a record of every server build tested.

## Installation

1. Download `AnonChat.phar` from the [v1.0.3 release](https://github.com/NhanAZ-Plugins/AnonChat/releases/tag/v1.0.3).
2. Place the PHAR in the server's `plugins` directory.
3. Start the server. The plugin creates `config.yml` in its data directory.
4. Send `[*] hello` as a player to use the anonymous broadcast.

## Configuration

| Setting | Default | Effect |
|---|---|---|
| `format` | `&f[&9Anonymous&f] <msg>` | Message template. `<msg>` is replaced with the player's text. Ampersand color codes in the template are interpreted. |
| `showMsgToCsl` | `true` | When true, the console log prefixes the message with the player's name. When false, it logs the message without that name. |

Invalid setting types fall back to the defaults. Player supplied ampersand codes are not interpreted as colors by this plugin. Restart the server after editing `config.yml`.

## Development and validation

CI uses [DevTools v1.0.1](https://github.com/NhanAZ/DevTools/releases/tag/v1.0.1) with a pinned Axolotl-PM source revision. It runs PHPStan at level max, builds a standalone PHAR, checks its manifest, source, configuration and license, then uploads the PHAR with build metadata. The exact server and DevTools revisions are recorded in the workflow and its run history.

To build locally with the same DevTools release, run:

```sh
php -d phar.readonly=0 path/to/DevTools/bin/devtools.php build --project=. --out=build
```

A successful build verifies packaging. A clean server startup checks loading. Sending chat through a Bedrock client is still needed to verify the visible player experience.

## Upgrade and rollback

Version 1.0.3 keeps the existing `[*]` prefix and configuration keys. It validates malformed configuration values, prevents player supplied ampersand codes from changing the message format, and ignores an empty anonymous message. Keep a copy of the previous PHAR and `config.yml` before upgrading. Stop the server before replacing the PHAR, and restore the saved files if behavior differs from your expectations. See [CHANGELOG.md](CHANGELOG.md) for the release history.

## License, credits and support

The source code is available under the existing [MIT License](LICENSE). The repository icon is credited to [Freepik via Flaticon](https://www.flaticon.com/free-icons/anonymous). For support, open a GitHub issue or use [NhanAZ Discord](https://discord.gg/j2X83ujT6c).
